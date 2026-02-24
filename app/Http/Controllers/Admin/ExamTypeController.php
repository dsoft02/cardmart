<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PinsImport;

class ExamTypeController extends Controller
{
    public function index()
    {
        $examTypes = ExamType::withCount([
            'pins as available_pins_count' => fn($q) => $q->where('status', 'available')
        ])->latest()->paginate(15);

        return view('admin.exam-types.index', compact('examTypes'));
    }

    public function create()
    {
        return view('admin.exam-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'result_page_url' => 'nullable|url',

            'about_content' => 'nullable|string',
            'how_to_buy_content' => 'nullable|string',
            'how_to_check_content' => 'nullable|string',

            'logo' => 'nullable|image',
            'cover_image' => 'nullable|image',
            'pin_background_image' => 'nullable|image',

            'is_active' => 'nullable|boolean',
        ]);

        // Normalize checkbox
        $data['is_active'] = $request->boolean('is_active');

        // Generate slug
        $data['slug'] = $this->generateUniqueSlug($data['name']);

        /*
        |--------------------------------------------------------------------------
        | Handle Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {

            $logoFile = $request->file('logo');
            $logoFileName = $data['slug'] . '-logo.' . $logoFile->getClientOriginalExtension();
            $logoPath = 'exam-types/logos/' . $logoFileName;

            Storage::disk('public')->put($logoPath, file_get_contents($logoFile));
            $data['logo'] = $logoPath;
        }

        if ($request->hasFile('cover_image')) {

            $coverFile = $request->file('cover_image');
            $coverFileName = $data['slug'] . '-cover.' . $coverFile->getClientOriginalExtension();
            $coverPath = 'exam-types/covers/' . $coverFileName;

            Storage::disk('public')->put($coverPath, file_get_contents($coverFile));
            $data['cover_image'] = $coverPath;
        }

        if ($request->hasFile('pin_background_image')) {

            $bgFile = $request->file('pin_background_image');
            $bgFileName = $data['slug'] . '-bg.' . $bgFile->getClientOriginalExtension();
            $bgPath = 'exam-types/pinbg/' . $bgFileName;

            Storage::disk('public')->put($bgPath, file_get_contents($bgFile));
            $data['pin_background_image'] = $bgPath;
        }

        ExamType::create($data);

        return redirect()
            ->route('admin.exam-types.index')
            ->with('success', 'Exam type created successfully.');
    }

    public function edit(ExamType $examType)
    {
        return view('admin.exam-types.edit', compact('examType'));
    }

    public function update(Request $request, ExamType $examType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'result_page_url' => 'nullable|url',

            'about_content' => 'nullable|string',
            'how_to_buy_content' => 'nullable|string',
            'how_to_check_content' => 'nullable|string',

            'logo' => 'nullable|image',
            'cover_image' => 'nullable|image',
            'pin_background_image' => 'nullable|image',

            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        /*
        |--------------------------------------------------------------------------
        | Regenerate slug only if name changed
        |--------------------------------------------------------------------------
        */
        if ($examType->name !== $data['name']) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $examType->id);
        }

        /*
        |--------------------------------------------------------------------------
        | Handle Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {

            if ($examType->logo) {
                Storage::disk('public')->delete($examType->logo);
            }

            $logoFile = $request->file('logo');
            $logoFileName = $examType->slug . '-logo.' . $logoFile->getClientOriginalExtension();
            $logoPath = 'exam-types/logos/' . $logoFileName;

            Storage::disk('public')->put($logoPath, file_get_contents($logoFile));
            $data['logo'] = $logoPath;
        }

        if ($request->hasFile('cover_image')) {

            if ($examType->cover_image) {
                Storage::disk('public')->delete($examType->cover_image);
            }

            $coverFile = $request->file('cover_image');
            $coverFileName = $examType->slug . '-cover.' . $coverFile->getClientOriginalExtension();
            $coverPath = 'exam-types/covers/' . $coverFileName;

            Storage::disk('public')->put($coverPath, file_get_contents($coverFile));
            $data['cover_image'] = $coverPath;
        }

        if ($request->hasFile('pin_background_image')) {

            if ($examType->pin_background_image) {
                Storage::disk('public')->delete($examType->pin_background_image);
            }

            $bgFile = $request->file('pin_background_image');
            $bgFileName = $examType->slug . '-bg.' . $bgFile->getClientOriginalExtension();
            $bgPath = 'exam-types/pinbg/' . $bgFileName;

            Storage::disk('public')->put($bgPath, file_get_contents($bgFile));
            $data['pin_background_image'] = $bgPath;
        }

        $examType->update($data);

        return back()->with('success', 'Exam type updated successfully.');
    }


    public function destroy(ExamType $examType)
    {
        if ($examType->pins()->where('status', 'sold')->exists()) {
            return back()->with('error', 'Cannot delete. Some PINs already sold.');
        }

        if ($examType->logo) Storage::disk('public')->delete($examType->logo);
        if ($examType->cover_image) Storage::disk('public')->delete($examType->cover_image);
        if ($examType->pin_background_image) Storage::disk('public')->delete($examType->pin_background_image);

        $examType->delete();

        return back()->with('success', 'Exam type deleted.');
    }


    private function generateUniqueSlug(string $name, $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (
        ExamType::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ExamType;
use App\Models\Faq;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function show($slug)
    {
        $exam = ExamType::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $faqs = Faq::where(function ($q) use ($exam) {
            $q->whereNull('exam_type_id')
                ->orWhere('exam_type_id', $exam->id);
        })->where('is_active', true)->get();

        return view('exam.show', compact('exam', 'faqs'));
    }
}

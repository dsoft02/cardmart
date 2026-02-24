<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PinsImport;
use App\Models\Pin;
use App\Models\ExamType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PinController extends Controller
{
    public function index(Request $request)
    {
        $query = Pin::with(['examType', 'orders', 'user'])->latest();

        // Filter by exam type
        if ($request->filled('exam_type')) {
            $query->where('exam_type_id', $request->exam_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pins = $query->paginate(30);

        $examTypes = ExamType::orderBy('name')->get();

        return view('admin.pins.index', compact('pins', 'examTypes'));
    }

    public function destroy(Pin $pin)
    {
        if ($pin->status === 'sold') {
            return back()->with('error', 'Cannot delete a sold PIN.');
        }

        $pin->delete();

        return back()->with('success', 'PIN deleted successfully.');
    }



    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pins-import-template.csv"',
        ];

        $columns = ['serial_number', 'pin'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // sample rows
            fputcsv($file, ['123456789012', '987654321098']);
            fputcsv($file, ['223456789012', '887654321098']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function import(Request $request)
    {
        $request->validate([
            'exam_type_id' => 'required|exists:exam_types,id',
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        $import = new PinsImport($request->exam_type_id);

        Excel::import(
            $import,
            $request->file('file')
        );

        $failed = $import->getFailedRows();

//        if (count($failed)) {
//
//            session()->put('pin_import_failed_rows', $failed);
//
//            return redirect()
//                ->route('admin.pins.failed.export')
//                ->with('warning', 'Import completed with some failed rows.');
//        }

        if (count($failed)) {

            session()->put('pin_import_failed_rows', $failed);

            return redirect()
                ->back()
                ->with('warning', 'Import completed with some failed rows. Failed file will download automatically.')
                ->with('trigger_failed_download', true);
        }

        return back()->with('success', 'PINs imported successfully.');
    }

    public function exportFailed(): StreamedResponse
    {
        $failedRows = session()->pull('pin_import_failed_rows', []);

        if (empty($failedRows)) {
            return redirect()->route('admin.pins.index');
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="failed-pin-import.csv"',
        ];

        $callback = function () use ($failedRows) {

            $file = fopen('php://output', 'w');

            fputcsv($file, ['row', 'serial_number', 'pin', 'reason']);

            foreach ($failedRows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

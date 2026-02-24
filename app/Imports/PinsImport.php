<?php

namespace App\Imports;

use App\Models\Pin;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PinsImport implements ToCollection, WithHeadingRow
{
    protected $examTypeId;
    protected array $failedRows = [];

    public function __construct($examTypeId)
    {
        $this->examTypeId = $examTypeId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            $rowNumber = $index + 1;

            $validator = Validator::make($row->toArray(), [
                'serial_number' => 'required',
                'pin' => 'required',
            ]);

            if ($validator->fails()) {
                $this->failedRows[] = [
                    'row' => $rowNumber,
                    'serial_number' => $row['serial_number'] ?? null,
                    'pin' => $row['pin'] ?? null,
                    'reason' => 'Validation failed',
                ];
                continue;
            }

            $serial = trim((string) $row['serial_number']);
            $pin = trim((string) $row['pin']);

            // Skip duplicates (existing serial or pin)
            if (
                Pin::where('serial_number', $serial)->exists() ||
                Pin::where('pin', $pin)->exists()
            ) {
                $this->failedRows[] = [
                    'row' => $rowNumber,
                    'serial_number' => $serial,
                    'pin' => $pin,
                    'reason' => 'Duplicate serial or PIN',
                ];
                continue;
            }

            Pin::create([
                'exam_type_id' => $this->examTypeId,
                'serial_number' => $serial,
                'pin' => $pin,
                'status' => 'available',
            ]);
        }
    }

    public function getFailedRows(): array
    {
        return $this->failedRows;
    }
}

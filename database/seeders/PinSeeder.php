<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ExamType;

class PinSeeder extends Seeder
{
    public function run(): void
    {
        $pinsPerExam = 200;

        $examTypes = ExamType::all();

        foreach ($examTypes as $exam) {

            $data = [];

            for ($i = 0; $i < $pinsPerExam; $i++) {
                $data[] = [
                    'exam_type_id' => $exam->id,
                    'pin' => $this->generatePin(),
                    'serial_number' => $this->generateSerial($exam->id),
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach (array_chunk($data, 100) as $chunk) {
                DB::table('pins')->insert($chunk);
            }

            $exam->increment('stock_count', $pinsPerExam);
        }
    }

    private function generatePin(): string
    {
        return random_int(100000000000, 999999999999); // 12 digit PIN
    }

    private function generateSerial($examId): string
    {
        return strtoupper('EX' . $examId . '-' . Str::random(8));
    }
}

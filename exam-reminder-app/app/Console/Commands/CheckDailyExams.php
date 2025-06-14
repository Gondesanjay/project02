<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exam;
use Carbon\Carbon;

class CheckDailyExams extends Command
{
    protected $signature = 'exams:check-daily';
    protected $description = 'Check for upcoming exams and send notifications';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow();
        $nextWeek = Carbon::now()->addDays(7);

        $urgentExams = Exam::whereBetween('exam_date', [Carbon::now(), $nextWeek])
            ->where('status', 'upcoming')
            ->get();

        foreach ($urgentExams as $exam) {
            $daysUntil = Carbon::now()->diffInDays($exam->exam_date, false);

            if ($daysUntil <= 1) {
                // Kirim notifikasi urgent
                $this->info("URGENT: Ujian {$exam->subject} besok!");
            } elseif ($daysUntil <= 7) {
                // Kirim reminder mingguan
                $this->info("Reminder: Ujian {$exam->subject} dalam {$daysUntil} hari");
            }
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Exam;
use Carbon\Carbon;

class SendExamReminders extends Command
{
    protected $signature = 'exam:send-reminders';
    protected $description = 'Send exam reminders for upcoming exams';

    public function handle()
    {
        // Ujian dalam 1 hari
        $tomorrowExams = Exam::upcoming()
            ->whereBetween('exam_date', [
                Carbon::now()->addDay()->startOfDay(),
                Carbon::now()->addDay()->endOfDay()
            ])
            ->get();

        // Ujian dalam 1 minggu
        $weekExams = Exam::upcoming()
            ->whereBetween('exam_date', [
                Carbon::now()->addWeek()->startOfDay(),
                Carbon::now()->addWeek()->endOfDay()
            ])
            ->get();

        foreach ($tomorrowExams as $exam) {
            $this->info("REMINDER: Ujian {$exam->subject} besok pada {$exam->exam_date->format('H:i')}");
            // Di sini bisa ditambahkan pengiriman email/SMS
        }

        foreach ($weekExams as $exam) {
            $this->info("REMINDER: Ujian {$exam->subject} dalam 1 minggu pada {$exam->exam_date->format('d M Y, H:i')}");
        }

        return 0;
    }
}

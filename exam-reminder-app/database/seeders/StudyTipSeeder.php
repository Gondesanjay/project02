<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudyTip;

class StudyTipSeeder extends Seeder
{
    public function run()
    {
        $tips = [
            ['category' => 'Persiapan', 'tip' => 'Buat jadwal belajar yang terstruktur minimal 2 minggu sebelum ujian'],
            ['category' => 'Persiapan', 'tip' => 'Siapkan semua materi dan catatan yang diperlukan'],
            ['category' => 'Teknik Belajar', 'tip' => 'Gunakan teknik Pomodoro: belajar 25 menit, istirahat 5 menit'],
            ['category' => 'Teknik Belajar', 'tip' => 'Buat mind map untuk memahami konsep secara visual'],
            ['category' => 'Motivasi', 'tip' => 'Ingat tujuan Anda dan visualisasikan kesuksesan'],
            ['category' => 'Kesehatan', 'tip' => 'Pastikan tidur cukup 7-8 jam setiap malam'],
            ['category' => 'Kesehatan', 'tip' => 'Konsumsi makanan bergizi dan minum air yang cukup'],
            ['category' => 'Hari H', 'tip' => 'Datang lebih awal ke lokasi ujian untuk menghindari stress'],
            ['category' => 'Hari H', 'tip' => 'Baca instruksi soal dengan teliti sebelum menjawab'],
        ];

        foreach ($tips as $tip) {
            StudyTip::create($tip);
        }
    }
}

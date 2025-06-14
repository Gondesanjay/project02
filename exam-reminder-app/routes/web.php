<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ExamDashboard;
use App\Livewire\ExamManager;

Route::get('/', ExamDashboard::class)->name('dashboard');
Route::get('/exams', ExamManager::class)->name('exams');

Route::get('/test', function () {
    return 'Laravel berjalan dengan baik!';
});

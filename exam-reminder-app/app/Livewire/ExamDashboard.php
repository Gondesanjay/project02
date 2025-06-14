<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exam;
use App\Models\StudyTip;
use Carbon\Carbon;

class ExamDashboard extends Component
{
    public $upcomingExams;
    public $todayTip;
    public $urgentExams;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->upcomingExams = Exam::upcoming()
            ->orderBy('exam_date', 'asc')
            ->take(5)
            ->get();

        $this->urgentExams = Exam::upcoming()
            ->whereDate('exam_date', '<=', Carbon::now()->addDays(7))
            ->orderBy('exam_date', 'asc')
            ->get();

        $this->todayTip = StudyTip::inRandomOrder()->first();
    }

    public function render()
    {
        return view('livewire.exam-dashboard');
    }
}

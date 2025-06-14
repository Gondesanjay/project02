<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exam;
use Carbon\Carbon;

class ExamManager extends Component
{
    public $subject = '';
    public $description = '';
    public $exam_date = '';
    public $exam_time = '';
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'subject' => 'required|min:3',
        'exam_date' => 'required|date|after:today',
        'exam_time' => 'required',
        'description' => 'nullable|string'
    ];

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->resetForm();
    }

    public function save()
    {
        $this->validate();

        $examDateTime = Carbon::parse($this->exam_date . ' ' . $this->exam_time);

        if ($this->editingId) {
            $exam = Exam::find($this->editingId);
            $exam->update([
                'subject' => $this->subject,
                'description' => $this->description,
                'exam_date' => $examDateTime,
            ]);
            session()->flash('message', 'Ujian berhasil diperbarui!');
        } else {
            Exam::create([
                'subject' => $this->subject,
                'description' => $this->description,
                'exam_date' => $examDateTime,
            ]);
            session()->flash('message', 'Ujian berhasil ditambahkan!');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $exam = Exam::find($id);
        $this->editingId = $id;
        $this->subject = $exam->subject;
        $this->description = $exam->description;
        $this->exam_date = $exam->exam_date->format('Y-m-d');
        $this->exam_time = $exam->exam_date->format('H:i');
        $this->showForm = true;
    }

    public function delete($id)
    {
        Exam::find($id)->delete();
        session()->flash('message', 'Ujian berhasil dihapus!');
    }

    public function markCompleted($id)
    {
        $exam = Exam::find($id);
        $exam->update(['status' => 'completed']);
        session()->flash('message', 'Ujian ditandai selesai!');
    }

    private function resetForm()
    {
        $this->subject = '';
        $this->description = '';
        $this->exam_date = '';
        $this->exam_time = '';
        $this->editingId = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $exams = Exam::orderBy('exam_date', 'asc')->get();
        return view('livewire.exam-manager', compact('exams'));
    }
}

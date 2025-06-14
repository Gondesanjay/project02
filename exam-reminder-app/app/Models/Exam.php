<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'description',
        'exam_date',
        'status'
    ];

    protected $casts = [
        'exam_date' => 'datetime'
    ];

    public function getDaysUntilExamAttribute()
    {
        return Carbon::now()->diffInDays($this->exam_date, false);
    }

    public function getFormattedExamDateAttribute()
    {
        return $this->exam_date->format('d M Y, H:i');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')->where('exam_date', '>', now());
    }
}

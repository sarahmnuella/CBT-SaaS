<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id', 'exam_id', 'student_id', 'question_list',
        'answers', 'correct_count', 'score', 'weighted_score',
        'started_at', 'finished_at', 'status'
    ];

    protected $casts = [
        'question_list' => 'array',
        'answers' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function exam() { return $this->belongsTo(Exam::class); }
    public function student() { return $this->belongsTo(Student::class); }
    public function tenant() { return $this->belongsTo(Tenant::class); }
}

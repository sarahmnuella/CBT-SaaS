<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id', 'teacher_id', 'subject_id', 'name', 'type',
        'question_order', 'total_questions', 'duration', 'token',
        'start_at', 'end_at', 'is_active'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function tenant() { return $this->belongsTo(Tenant::class); }
    public function examResults() { return $this->hasMany(ExamResult::class); }
}

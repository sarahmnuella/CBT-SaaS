<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use BelongsToTenant;
    protected $fillable = [
        'tenant_id', 'teacher_id', 'subject_id', 'type',
        'question', 'image', 'option_a', 'option_b', 'option_c',
        'option_d', 'option_e', 'answer', 'weight'
    ];

    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function tenant() { return $this->belongsTo(Tenant::class); }
}

<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use BelongsToTenant;
    protected $fillable = ['tenant_id', 'name', 'code'];

    public function teachers() { return $this->hasMany(Teacher::class); }
    public function questions() { return $this->hasMany(Question::class); }
    public function exams() { return $this->hasMany(Exam::class); }
    public function tenant() { return $this->belongsTo(Tenant::class); }
}

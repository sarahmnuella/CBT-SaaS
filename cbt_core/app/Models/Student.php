<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use BelongsToTenant;
    protected $fillable = ['tenant_id', 'user_id', 'class_id', 'nisn', 'name', 'email', 'gender'];

    public function user() { return $this->belongsTo(User::class); }
    public function class() { return $this->belongsTo(SchoolClass::class, 'class_id'); }
    public function tenant() { return $this->belongsTo(Tenant::class); }
    public function examResults() { return $this->hasMany(ExamResult::class); }
}

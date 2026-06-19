<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use BelongsToTenant;
    protected $fillable = ['tenant_id', 'user_id', 'nip', 'name', 'email', 'phone'];

    public function user() { return $this->belongsTo(User::class); }
    public function tenant() { return $this->belongsTo(Tenant::class); }
    public function questions() { return $this->hasMany(Question::class); }
    public function exams() { return $this->hasMany(Exam::class); }
}

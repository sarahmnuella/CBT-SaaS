<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'nama_sekolah', 'slug', 'email', 'phone', 'alamat', 'logo',
        'status', 'trial_ends_at', 'expired_at', 'max_students', 'max_teachers', 'is_active'
    ];

    protected $casts = [
        'trial_ends_at' => 'date',
        'expired_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function users() { return $this->hasMany(User::class); }
    public function teachers() { return $this->hasMany(Teacher::class); }
    public function students() { return $this->hasMany(Student::class); }
    public function exams() { return $this->hasMany(Exam::class); }

    public function isExpired(): bool
    {
        if ($this->status === 'premium') {
            return $this->expired_at && $this->expired_at->isPast();
        }
        if ($this->status === 'trial') {
            return $this->trial_ends_at && $this->trial_ends_at->isPast();
        }
        return false;
    }

    public function isActive(): bool
    {
        return $this->is_active && !$this->isExpired();
    }
}

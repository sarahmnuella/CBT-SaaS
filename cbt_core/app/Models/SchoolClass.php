<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use BelongsToTenant;
    protected $table = 'classes';
    protected $fillable = ['tenant_id', 'major_id', 'name'];

    public function major() { return $this->belongsTo(Major::class, 'major_id'); }
    public function students() { return $this->hasMany(Student::class, 'class_id'); }
    public function tenant() { return $this->belongsTo(Tenant::class); }
}

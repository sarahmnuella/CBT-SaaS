<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use BelongsToTenant;
    protected $fillable = ['tenant_id', 'name'];

    public function classes() { return $this->hasMany(SchoolClass::class, 'major_id'); }
    public function tenant() { return $this->belongsTo(Tenant::class); }
}

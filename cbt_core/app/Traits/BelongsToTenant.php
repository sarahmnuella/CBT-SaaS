<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            if (session('tenant_id') && empty($model->tenant_id)) {
                $model->tenant_id = session('tenant_id');
            }
        });
    }
}

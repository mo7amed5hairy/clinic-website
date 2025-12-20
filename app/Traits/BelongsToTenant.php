<?php

namespace App\Traits;

use App\Scopes\TenantScope;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (app()->has('tenant') && empty($model->tenant_id)) {
                $model->tenant_id = app('tenant')->id;
            }
        });
    }
}
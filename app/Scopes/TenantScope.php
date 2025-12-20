<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Stancl\Tenancy\Facades\Tenancy;

/**
 * @implements Scope<Model>
 */
class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model   $model
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Tenancy::initialized()) {
            $builder->where(
                $model->getTable() . '.tenant_id',
                tenant('id')
            );
        }
    }
}

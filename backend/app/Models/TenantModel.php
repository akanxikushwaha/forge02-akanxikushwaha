<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class TenantModel extends Model
{
    /**
     * Boot the tenant model.
     *
     * Automatically adds organization_id scope when a user is authenticated.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('organization', function (Builder $builder) {
            if (auth()->check() && auth()->user()->organization_id) {
                $builder->where($builder->getModel()->getTable() . '.organization_id', auth()->user()->organization_id);
            }
        });

        static::creating(function (Model $model) {
            if (auth()->check() && ! $model->organization_id) {
                $model->organization_id = auth()->user()->organization_id;
            }
        });
    }
}

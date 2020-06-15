<?php

namespace App\Traits;

use App\Models\Company;
use App\Scopes\CompanyScope;
use App\Scopes\IsDeleteScope;
use Illuminate\Support\Facades\Auth;

trait  HasModify
{
    protected static function boot()
    {
        parent::boot();
        // Add scopes
        static::addGlobalScope(new IsDeleteScope);
        // static::addGlobalScope(new CompanyScope(Auth::guard('admin')->user()));

        static::creating(function ($model) {
            $schemaBuilder = $model->getConnection()->getSchemaBuilder();
            if ($schemaBuilder->hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = 'admins.'.(Auth::guard('admin')->user() ? Auth::guard('admin')
                                                                                   ->user()->id : $model->created_by);
            }
            if ($schemaBuilder->hasColumn($model->getTable(), 'company_id')) {
                $company_id = $model->company_id;
                // Check is supper admin
                if (Auth::guard('admin')->user() && ! Auth::guard('admin')->user()->adminGroup->is_system) {
                    $company_id = Auth::guard('admin')->user()->adminGroup->company_id;
                }
                $model->company_id = $company_id;
            }
        });

        static::updating(function ($model) {
            $schemaBuilder = $model->getConnection()->getSchemaBuilder();
            if ($schemaBuilder->hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = 'admins.'.Auth::guard('admin')->user()->id;
            }
            if ($schemaBuilder->hasColumn($model->getTable(), 'company_id')) {
                $company_id = $model->company_id;
                // Check is supper admin
                if (Auth::guard('admin')->user() && ! Auth::guard('admin')->user()->adminGroup->is_system) {
                    $company_id = Auth::guard('admin')->user()->adminGroup->company_id;
                }
                $model->company_id = $company_id;
            }
        });

        static::deleting(function ($model) {
            $schemaBuilder = $model->getConnection()->getSchemaBuilder();
            if ($schemaBuilder->hasColumn($model->getTable(), 'is_deleted') &&
                $schemaBuilder->hasColumn($model->getTable(), 'deleted_at') &&
                $schemaBuilder->hasColumn($model->getTable(), 'deleted_by') &&
                Auth::guard('admin')->user()
            ) {
                $model->is_deleted = 1;
                $model->deleted_at = date('U');
                $model->deleted_by = 'admins.'.Auth::guard('admin')->user()->id;
                $model->save();

                return false;
            }
        });
        parent::boot();
    }
}

<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class IsDeleteScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $schemaBuilder = $model->getConnection()->getSchemaBuilder();
        if ($schemaBuilder->hasColumn($model->getTable(), 'is_deleted')) {
            $builder->where('is_deleted', 0);
        }
    }
}

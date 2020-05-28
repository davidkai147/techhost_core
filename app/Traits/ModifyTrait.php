<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait ModifyTrait
{
    public static $CREATED_BY = 'created_by';

    public static $UPDATED_BY = 'updated_by';

    /**
     * @return int|string
     */
    private static function currentUser()
    {
        if (request()->bearerToken()) {
            $user = auth()->user();

            return $user->id ?? null;
        }
    }

    /**
     * Register the model events for updating the user audit trails.
     */
    public static function bootModifyTrait()
    {
        static::saving(function ($model) {
            /**
             * @var $model \Illuminate\Database\Eloquent\Model
             */
            $id = $model->getAttribute('id');

            if (isset($id)) {
                if (Schema::hasColumn($model->getTable(), static::$UPDATED_BY)) {
                    $model->{static::$UPDATED_BY} = self::currentUser();
                }
            } else {
                if (Schema::hasColumn($model->getTable(), static::$CREATED_BY)) {
                    $model->{static::$CREATED_BY} = self::currentUser();
                }
            }
        });
    }
}

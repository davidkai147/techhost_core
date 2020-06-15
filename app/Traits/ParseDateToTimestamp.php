<?php


namespace App\Traits;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait ParseDateToTimestamp
{
    /**
     *Parse date to timestamp when creating and updating
     */
    public static function bootParseDateToTimestamp(){
        static::creating(function(Model $model) {
            $model->created_at = Carbon::now()->timestamp;
            $model->updated_at = Carbon::now()->timestamp;
        });

        static::updating(function(Model $model) {
            $model->updated_at = Carbon::now()->timestamp;
        });
    }
}

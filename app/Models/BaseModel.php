<?php

namespace App\Models;

use App\Traits\ModifyTrait;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use ModifyTrait;

    /**
     * add more fields when response data
     *
     * @var array
     */
    protected $appends = [
        'latest_at',
    ];

    /**
     * Create latest_at column
     *
     * @return string
     */
    public function getLatestAtAttribute()
    {
        $latest_at = $this->created_at >= $this->updated_at ? $this->created_at : $this->updated_at;

        return $this->convertDate($latest_at);
    }

    /**
     * @param $date
     * @param string $format
     * @return false|string|null
     */
    public function convertDate($date, $format = 'd-m-Y H:i:s')
    {
        if (! empty($date)) {
            return Date($format, strtotime($date));
        } else {
            return null;
        }
    }
}

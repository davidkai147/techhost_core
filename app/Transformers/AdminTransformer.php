<?php


namespace App\Transformers;


use App\Models\Admin;
use App\Models\AdminGroups;
use App\Transformers\AdminGroupTransformer;
use Carbon\Carbon;
use Flugg\Responder\Transformers\Transformer;

class AdminTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * A list of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param Admin $admin
     * @return array
     */
    public function transform(Admin $admin): array
    {
        return [
            'id'                => (string) $admin->id,
            'admin_name'        => (string) $admin->name,
            'email'          => (string) $admin->email,
            'is_active'         => (int)    $admin->is_active,
            'is_deleted'        => (int)    $admin->is_deleted,
            'created_at'        => Carbon::parse($admin->created_at)->format('Y-m-d H:i'),
            'created_by'        => (string) $admin->created_by,
            'updated_at'        => $admin->updated_at ? Carbon::parse($admin->updated_at)->format('Y-m-d H:i') : '',
            'updated_by'        => $admin->updated_by ? $admin->updated_by : '',
            'deleted_at'        => $admin->deleted_at ? Carbon::parse($admin->deleted_at)->format('Y-m-d H:i') : '',
            'deleted_by'        => $admin->deleted_by ? $admin->deleted_by : ''
        ];
    }
}

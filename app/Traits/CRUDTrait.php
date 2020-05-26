<?php
namespace App\Traits;

use App\Services\AuthService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait CRUDTrait
{
    protected $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * Hàm read dữ liệu
     * @param Request $request
     * @param Model $model
     * @return array
     */
    private function read(Model $model, $hide_column = [])
    {
        $request = request();
        //dd($request);
        $filters = $request->filters ?? [];
        $withs = $request->withs ?? [];
        $ids = $request->ids ?? [];
        $selects = $request->selects ?? [];
        $conditions = $request->conditions ?? [];
        $pageshow = $request->get('perPage', 0);
        $order_by = $request->order_by ?? ['key' => 'id', 'value' => 'desc'];
        $with_trash = $request->get('with_trash', false);

        if ($with_trash) {
            $model = $model->withTrashed();
        }

        if (count($selects) > 0) {
            $model = $model->select($selects);
        }

        if (count($withs) > 0) {
            foreach ($withs as $with) {
                $arrayWith = json_decode($with, true);
                // dd($arrayWith);
                if (!isset($arrayWith['conditions'])) {
                    $model = $model->with("{$arrayWith['relation_name']}");
                } else {
                    $model = $model->with(["{$arrayWith['relation_name']}" => function ($query) use ($arrayWith) {
                        $query = $this->filter_withs($query, $arrayWith['conditions']);
                    }]);
                }
            }
        }

        if (count($conditions) > 0) {
            foreach ($conditions as $condition) {
                $arrayConditions = json_decode($condition, true);
                $model = $this->filters($arrayConditions, $model, []);
            }
        }

        if (count($ids) > 1) {
            $model = $model->whereIn('id', $ids);
        } else if (count($ids) == 1) {
            $model = $model->where('id', $ids[0]);
        }

        foreach ($filters as $filter) {
            $model = $this->filters($filter, $model, $hide_column);
        }

        if (isset($order_by['key']) && isset($order_by['value'])) {
            $model = $model->orderBy($order_by['key'], $order_by['value']);
        }

            if (isset($pageshow) && is_numeric($pageshow) && $pageshow > 0) {
                //$model = $model->paginateTrans((int)$pageshow);
                $model = $model->paginate((int)$pageshow);
            } else {
                if (count($ids) === 1) {
                    $model = $model->first();
                } else {
                    $model = $model->get();
                }
                // $model = $model->toTrans();
            }
        return $model;
    }

    /**
     * Hàm filter dữ liệu database
     * @param $filter
     * @param $model
     * @return mixed
     */
    private function filters($filter, $model, $denied_column)
    {
        $type = $filter['type'] ?? 'where';
        $type = strtolower(trim($type));
        $column = $filter['column'] ?? null;
        $column = strtolower(trim($column));
        $condition = isset($filter['condition']) ? strtolower(trim($filter['condition'])) : '';
        $absolute = isset($filter['absolute']) ? boolval($filter['absolute']) : false;
        $empty = isset($filter['empty']) ? boolval($filter['empty']) : true;
        $relationship = isset($filter['relationship']) ? trim($filter['relationship']) : null;
        $value = $filter['value'] ?? null;

        if (in_array($column, $denied_column)) {
            // chặn không cho search column chỉ định
            return $model;
        }

        switch ($type) {
            case 'where':
                if (!$empty && empty($value)) return $model;

                if (!$absolute && is_string($value)) {
                    $value = '%' . $value . '%';
                }
                if (empty($condition)) {
                    $model = $model->where($column, $value);
                } else {
                    $model = $model->where($column, $condition, $value);
                }
                break;
            case 'orwhere':
                if (!$empty && empty($value)) return $model;

                if (!$absolute && is_string($value)) {
                    $value = '%' . $value . '%';
                }
                if (empty($condition)) {
                    $model = $model->orWhere($column, $value);
                } else {
                    $model = $model->orWhere($column, $condition, $value);
                }
                break;
            case 'wherenull':
                $model = $model->whereNull($column);
                break;
            case 'wherenotnull':
                $model = $model->whereNotNull($column);
                break;
            case 'orwherenull':
                $model = $model->orWhereNull($column);
                break;
            case 'orwherenotnull':
                $model = $model->orWhereNotNull($column);
                break;
            case 'wherebetween':
                $value = (array)$value;
                $model = $model->whereBetween($column, array_values($value));
                break;
            case 'orwherebetween':
                $value = (array)$value;
                $model = $model->orWhereBetween($column, array_values($value));
                break;
            case 'wherenotbetween':
                $value = (array)$value;
                $model = $model->whereNotBetween($column, array_values($value));
                break;
            case 'orwherenotbetween':
                $value = (array)$value;
                $model = $model->orWhereNotBetween($column, array_values($value));
                break;
            case 'wherein':
                $value = (array)$value;
                $model = $model->whereIn($column, array_values($value));
                break;
            case 'wherenotin':
                $value = (array)$value;
                $model = $model->whereNotIn($column, array_values($value));
                break;
            case 'orwherein':
                $value = (array)$value;
                $model = $model->orWhereIn($column, array_values($value));
                break;
            case 'orwherenotin':
                $value = (array)$value;
                $model = $model->orWhereNotIn($column, array_values($value));
                break;
            case 'wheredate':
                if (empty($condition)) {
                    $model = $model->whereDate($column, $value);
                } else {
                    $model = $model->whereDate($column, $condition, $value);
                }
                break;
            case 'wheremonth':
                if (empty($condition)) {
                    $model = $model->whereMonth($column, $value);
                } else {
                    $model = $model->whereMonth($column, $condition, $value);
                }
                break;
            case 'whereday':
                if (empty($condition)) {
                    $model = $model->whereDay($column, $value);
                } else {
                    $model = $model->whereDay($column, $condition, $value);
                }
                break;
            case 'whereyear':
                if (empty($condition)) {
                    $model = $model->whereYear($column, $value);
                } else {
                    $model = $model->whereYear($column, $condition, $value);
                }
                break;
            case 'wheretime':
                if (empty($condition)) {
                    $model = $model->whereTime($column, $value);
                } else {
                    $model = $model->whereTime($column, $condition, $value);
                }
                break;
            case 'has':
                if (!empty($relationship) && !is_null($relationship) && count($relationship) > 0) {
                    foreach ($relationship as $rel) {
                        $model = $model->has($rel['name']);
                    }
                }
                break;
            case 'wherehas':
                if (!empty($relationship)) {
                    $model = $model->whereHas($relationship, function ($query) use ($filter, $denied_column) {
                        foreach ($filter['conditions'] as $condition) {
                            $query = $this->filters($condition, $query, $denied_column);
                        }

                    });
                }
                break;
            default:
                break;
        }
        return $model;
    }


    /**
     * Filter relationship
     * @param $query
     * @param $conditions
     * @return mixed
     */
    private function filter_withs($query, $conditions)
    {
        // trả về khi column rỗng
        foreach ($conditions as $condi) {
            $type = isset($condi['type']) ? strtolower(trim($condi['type'])) : 'where';
            $selects = isset($condi['selects']) ? (array)$condi['selects'] : [];
            $denied_column = isset($condi['denied_column']) ? (array)$condi['denied_column'] : [];
            $column = isset($condi['column']) ? trim($condi['column']) : null;
            $condition = isset($condi['condition']) ? strtolower(trim($condi['condition'])) : '';
            $empty = isset($condi['empty']) ? boolval($condi['empty']) : true;
            $absolute = isset($condi['absolute']) ? boolval($condi['absolute']) : false;
            $value = isset($condi['value']) ? trim($condi['value']) : null;
            $relationship = isset($condi['relationship']) ? trim($condi['relationship']) : null;

            if (count($selects) > 0) {
                $query = $query->select($selects);
            }

            if (!isset($condi['column']) && empty($condi['column'])) continue;

            // chặn không cho search column chỉ định
            if (isset($column) && in_array($column, $denied_column)) continue;

            switch ($type) {
                case 'where':
                    if (!$empty && empty($value)) return $query;
                    if (!$absolute && is_string($value)) {
                        $value = '%' . $value . '%';
                    }
                    if (empty($condition)) {
                        $query = $query->where($column, $value);
                    } else {
                        $query = $query->where($column, $condition, $value);
                    }
                    break;
                case 'orwhere':
                    if (!$empty && empty($value) === '') return $query;

                    if (!$absolute && is_string($value)) {
                        $value = '%' . $value . '%';
                    }
                    if (empty($condition)) {
                        $query = $query->orWhere($column, $value);
                    } else {
                        $query = $query->orWhere($column, $condition, $value);
                    }
                    break;
                case 'wherenull':
                    $query = $query->whereNull($column);
                    break;
                case 'wherenotnull':
                    $query = $query->whereNotNull($column);
                    break;
                case 'orwherenull':
                    $query = $query->orWhereNull($column);
                    break;
                case 'orwherenotnull':
                    $query = $query->orWhereNotNull($column);
                    break;
                case 'wherebetween':
                    $value = (array)$value;
                    $query = $query->whereBetween($column, array_values($value));
                    break;
                case 'orwherebetween':
                    $value = (array)$value;
                    $query = $query->orWhereBetween($column, array_values($value));
                    break;
                case 'wherenotbetween':
                    $value = (array)$value;
                    $query = $query->whereNotBetween($column, array_values($value));
                    break;
                case 'orwherenotbetween':
                    $value = (array)$value;
                    $query = $query->orWhereNotBetween($column, array_values($value));
                    break;
                case 'wherein':
                    $value = (array)$value;
                    $query = $query->whereIn($column, array_values($value));
                    break;
                case 'wherenotin':
                    $value = (array)$value;
                    $query = $query->whereNotIn($column, array_values($value));
                    break;
                case 'orwherein':
                    $value = (array)$value;
                    $query = $query->orWhereIn($column, array_values($value));
                    break;
                case 'orwherenotin':
                    $value = (array)$value;
                    $query = $query->orWhereNotIn($column, array_values($value));
                    break;
                case 'wheredate':
                    if (empty($condition)) {
                        $query = $query->whereDate($column, $value);
                    } else {
                        $query = $query->whereDate($column, $condition, $value);
                    }
                    break;
                case 'wheremonth':
                    if (empty($condition)) {
                        $query = $query->whereMonth($column, $value);
                    } else {
                        $query = $query->whereMonth($column, $condition, $value);
                    }
                    break;
                case 'whereday':
                    if (empty($condition)) {
                        $query = $query->whereDay($column, $value);
                    } else {
                        $query = $query->whereDay($column, $condition, $value);
                    }
                    break;
                case 'whereyear':
                    if (empty($condition)) {
                        $query = $query->whereYear($column, $value);
                    } else {
                        $query = $query->whereYear($column, $condition, $value);
                    }
                    break;
                case 'wheretime':
                    if (empty($condition)) {
                        $query = $query->whereTime($column, $value);
                    } else {
                        $query = $query->whereTime($column, $condition, $value);
                    }
                    break;
                case 'has':
                    if (!empty($relationship) && !is_null($relationship) && count($relationship) > 0) {
                        foreach ($relationship as $rel) {
                            $query = $query->has($rel['name']);
                        }
                    }
                    break;
                case 'wherehas':
                    if (!empty($relationship) && !is_null($relationship) && count($relationship) > 0) {
                        foreach ($relationship as $rel) {
                            $query = $query->whereHas($rel['name'], function ($query) use ($rel) {
                                $this->filters($rel, $query);
                            });
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        return $query;
    }

    /**
     * Tìm model by id
     * @param Model $model
     * @param $id
     * @return array
     */
    private function find(Model $model)
    {
        $request = request();
        $table = $model->getTable();
        $rule = [
            'id' => 'required|exists:' . $table . ',id',
        ];
        $validate = $this->validateData($request->all(), $rule);
        if ($validate->fails()) {
            return [
                'data' => $validate->errors(),
                'message' => trans('global.validate_fails'),
                'code' => VALIDATE,
            ];
        }
        return [
            'data' => $model->find($request->get('id', null))->toTrans(),
            'message' => trans('global.success'),
            'code' => SUCCESS,
        ];
    }

    /**
     * Xóa tạm 1 record
     * @param Request $request
     * @param Model $model
     * @param bool $check_user_create
     * @return array
     */
    private function delete(Model $model, $check_user_create = false)
    {
        $request = request();
        $table = $model->getTable();
        $rule = [
            'ids' => 'required|array',
            'ids.*' => 'required|exists:' . $table . ',id',
        ];
        $validate = $this->validateData($request->all(), $rule);
        if ($validate->fails()) {
            return [
                'data' => $validate->errors(),
                'message' => trans('global.validate_fails'),
                'code' => VALIDATE,
            ];
        }
        $user = $this->getCurrentUser();
        $model = $model->whereIn('id', $request->ids);
        if ($check_user_create) {
            $model = $model->where('created_user_id', $user->id)->get();
        } else {
            $model = $model->get();
        }
        if ($model->count()) {
            foreach ($model as $item) {
                $item->delete();
            }
            return [
                'data' => $model->toTrans(),
                'message' => trans('global.success'),
                'code' => SUCCESS,
            ];
        } else {
            return [
                'data' => $model->toTrans(),
                'message' => trans('global.not_found_data'),
                'code' => NOT_FOUND_DATA,
            ];
        }
    }

    /**
     * Xóa vĩnh viễn 1 record
     * @param Request $request
     * @param Model $model
     * @param bool $check_user_create
     * @return array
     */
    private function remove(Model $model, $check_user_create = false)
    {
        $request = request();
        $table = $model->getTable();
        $rule = [
            'ids' => 'required|array',
            'ids.*' => 'required|exists:' . $table . ',id',
        ];
        $validate = $this->validateData($request->all(), $rule);
        if ($validate->fails()) {
            return [
                'data' => $validate->errors(),
                'message' => trans('global.validate_fails'),
                'code' => VALIDATE,
            ];
        }
        $user = $this->getCurrentUser();
        $model = $model->withTrashed()->whereIn('id', $request->ids);
        if ($check_user_create) {
            $model = $model->where('created_user_id', $user->id)->get();
        } else {
            $model = $model->get();
        }
        if ($model->count()) {
            foreach ($model as $item) {
                $item->forceDelete();
            }
            return [
                'data' => $model->toTrans(),
                'message' => trans('global.success'),
                'code' => SUCCESS,
            ];
        } else {
            return [
                'data' => $model->toTrans(),
                'message' => trans('global.not_found_data'),
                'code' => NOT_FOUND_DATA,
            ];
        }
    }

    /**
     * Restore lại 1 record sau khi xóa tạm
     * @param Request $request
     * @param Model $model
     * @param bool $check_user_create
     * @return array
     */
    private function restore(Model $model, $check_user_create = false)
    {
        $request = request();
        $table = $model->getTable();
        $rule = [
            'ids' => 'required|array',
            'ids.*' => 'required|exists:' . $table . ',id',
        ];

        $validate = $this->validateData($request->all(), $rule);
        if ($validate->fails()) {
            return [
                'data' => $validate->errors(),
                'message' => trans('global.validate_fails'),
                'code' => VALIDATE,
            ];
        }
        $user = $this->getCurrentUser();
        $model = $model->withTrashed()->whereIn('id', $request->ids);
        if ($check_user_create) {
            $model = $model->where('created_user_id', $user->id)->get();
        } else {
            $model = $model->get();
        }
        if ($model->count()) {
            foreach ($model as $item) {
                $item->restore();
            }
            return [
                'data' => $model->toTrans(),
                'message' => trans('global.success'),
                'code' => SUCCESS,
            ];
        } else {
            return [
                'data' => $model->toTrans(),
                'message' => trans('global.not_found_data'),
                'code' => NOT_FOUND_DATA,
            ];
        }
    }

    /**
     * Thay đổi Status của 1 record
     * @param Request $request
     * @param Model $model
     * @param bool $check_user_create
     * @return array
     */
    private function status(Model $model, $check_user_create = false)
    {
        $request = request();
        $table = $model->getTable();
        $rule = [
            'ids' => 'required|array',
            'ids.*' => 'required|exists:' . $table . ',id',
            'status' => 'required|in:pending,approval,success,fail,reject,waiting,publish,invisible',
        ];
        $validate = $this->validateData($request->all(), $rule);
        if ($validate->failed()) {
            return [
                'data' => $validate->errors(),
                'message' => trans('global.validate_fails'),
                'code' => VALIDATE,
            ];
        }
        $user = $this->getCurrentUser();
        $model = $model->withTrashed()->whereIn('id', $request->ids)->where('created_user_id', $user->id)->get();
        if ($check_user_create) {
            $model = $model->where('created_user_id', $user->id)->update(['status' => $request->status]);
        } else {
            $model = $model->update(['status' => $request->status]);
        }
        if ($model > 0) {
            return [
                'data' => $model->toTrans(),
                'message' => trans('global.success'),
                'code' => SUCCESS,
            ];
        }
        return [
            'data' => $model->toTrans(),
            'message' => trans('global.not_found_data'),
            'code' => NOT_FOUND_DATA,
        ];
    }

    /**
     * Đếm số lượng dữ liệu xóa tạm
     * @param Request $request
     * @param Model $model
     * @return array
     */
    private function countTrash(Model $model)
    {
        $request = request();
        $filters = $request->filters ?? [];

        foreach ($filters as $filter) {
            $model = $this->filters($filter, $model);
        }

        $model = $model->onlyTrashed()->count();
        return [
            'data' => $model,
            'message' => trans('global.success'),
            'code' => SUCCESS,
        ];
    }

    /**
     * Đếm số lượng dữ liệu không xóa tạm
     * @param Request $request
     * @param Model $model
     * @return array
     */
    private function countNonTrash(Model $model)
    {
        $request = request();
        $filters = $request->filters ?? [];

        foreach ($filters as $filter) {
            $model = $this->filters($filter, $model);
        }

        $model = $model->count();
        return [
            'data' => $model,
            'message' => trans('global.success'),
            'code' => SUCCESS,
        ];
    }

    /**
     * Đếm loại status nào đó
     * @param Request $request
     * @param Model $model
     * @return array
     */
    private function countStatus(Model $model)
    {
        $request = request();
        $filters = $request->filters ?? [];

        foreach ($filters as $filter) {
            $model = $this->filters($filter, $model);
        }

        $model = $model->withTrashed()->where('status', trim($request->status))->count();
        return [
            'data' => $model,
            'message' => trans('global.success'),
            'code' => SUCCESS,
        ];
    }

    /**
     * Nhân bản 1 dữ liệu
     * @param Request $request
     * @param Model $model
     * @return array
     */
    private function duplicateData(Model $model)
    {
        $request = request();
        $items = $model->whereIn('id', $request->ids)->get();
        $values = [];
        foreach ($items as $item) {
            $new = $item->replicate();
            $new->save();
            $values[] = $new;
        }
        return [
            'data' => $values,
            'message' => trans('global.success'),
            'code' => SUCCESS,
        ];
    }

    /**
     * Hàm hỗ trợ validate nhanh
     * @param array $data
     * @param $rule
     * @param array $message
     * @return \Illuminate\Validation\Validator
     */
    public function validateData($data = [], $rule, $message = [])
    {
        return Validator::make($data, $rule, $message);
    }

    /**
     * Lấy user phiên đăng nhập hiện tại
     * @return Authenticatable|null
     */
    public function getCurrentUser()
    {
        return $this->authService->getCurrentUser();
    }

    /**
     * Lấy toàn bộ danh sách các cột model
     * @param Model $model
     * @return array
     */
    private function fillable(Model $model)
    {
        return [
            'data' => $model->getFillable(),
            'message' => trans('global.success'),
            'code' => SUCCESS,
        ];
    }
}

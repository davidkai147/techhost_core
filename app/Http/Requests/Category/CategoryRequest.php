<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:10|unique:categories,name',
            'parent_id' => 'integer',
            'status' => 'in:active,deactive',
            'is_featured' => 'in:0,1',
            'description' => 'max:1000'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name required',
            'name.min' => 'name min',
            'name.max' => 'name max',
            'name.unique' => 'name unique',
            'parent_id.max' => 'parent_id max',
            'status.in' => 'status in',
            'is_featured.in' => 'is_featured in',
            'description.max' => 'description required',
        ];
    }
}

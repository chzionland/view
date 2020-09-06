<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CategoryRequest extends FormRequest
{
    protected $rules = [
        'thumbnail' => 'nullable|url|max:255',

        'name_cn' => 'required|max:15|unique:categories,name->cn',
        'name_en' => 'required|max:63|unique:categories,name->en',
        'slug' => 'unique:categories,slug',

        'category_id' => 'required_if:is_column,==,"0"|empty_if:is_column,==,"1"',
    ];

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name_en),
        ]);
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = $this->rules;

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return $rules;
            }
            case 'PUT':
            case 'PATCH': {
                $rules['name_cn'] = 'required|max:15|unique:categories,name->cn,' . $this->category->id;
                $rules['name_en'] = 'required|max:63|unique:categories,name->en,' . $this->category->id;
                $rules['slug'] = 'unique:categories,slug,' . $this->category->id;
                return $rules;
            }
        }
    }

    public function messages()
    {
        return [
            'thumbnail.url' => trans('admin_CRUD.must_url'),
            'thumbnail.max' => trans('admin_CRUD.max_limit_255'),

            'name_cn.required' => trans('admin_CRUD.is_must'),
            'name_en.required' => trans('admin_CRUD.is_must'),
            'name_cn.max' => trans('admin_CRUD.max_limit_15_cn'),
            'name_en.max' => trans('admin_CRUD.max_limit_63_en'),
            'name_cn.unique' => trans('admin_CRUD.already_exist'),
            'name_en.unique' => trans('admin_CRUD.already_exist'),
            'slug.unique' => trans('admin_CRUD.already_exist'),

            'category_id.required_if' => trans('admin_CRUD.required_if_is_sub_category'),
            'category_id.empty_if' => trans('admin_CRUD.empty_if_is_column'),
        ];
    }
}

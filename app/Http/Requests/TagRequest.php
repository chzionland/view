<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class TagRequest extends FormRequest
{
    // TODO: Regex
    protected $rules = [
        'name_cn' => 'required|max:15|unique:tags,name->cn',
        'name_en' => "required|max:63|unique:tags,name->en",
    ];

    protected function prepareForValidation()
    {
        $this->merge([
            'name_en' => Str::slug($this->name_en),
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
                $rules['name_cn'] = 'required|max:15|unique:tags,name->cn,' . $this->tag->id;
                $rules['name_en'] = 'required|max:63|unique:tags,name->en,' . $this->tag->id;
                return $rules;
            }
        }
    }

    public function messages()
    {
        return [
            'name_cn.required' => trans('admin_CRUD.is_must'),
            'name_en.required' => trans('admin_CRUD.is_must'),
            'name_cn.max' => trans('admin_CRUD.max_limit_15_cn'),
            'name_en.max' => trans('admin_CRUD.max_limit_63_en'),
            'name_cn.unique' => trans('admin_CRUD.already_exist'),
            'name_en.unique' => trans('admin_CRUD.already_exist'),
            // 'name_en.regex' => trans('admin_CRUD.legal_english_name')
        ];
    }
}
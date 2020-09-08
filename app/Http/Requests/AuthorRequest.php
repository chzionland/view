<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AuthorRequest extends FormRequest
{
    protected $rules = [
        'thumbnail' => 'nullable|url|max:255',

        'name_cn' => 'required|max:15|unique:tags,name->cn',
        'name_en' => "required|max:63|unique:tags,name->en",
        'slug' => "unique:tags,slug",

        'intro_cn' => 'max:250',
        'intro_en' => 'max:1500',
    ];

    protected function prepareForValidation()
    {
        $this->merge([
            'name_cn' => str_replace(' ', '', $this->title_cn),
            'name_en' => Str::ucwords($this->name_en),
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
                $rules['name_cn'] = 'required|max:15|unique:authors,name->cn,' . $this->author->id;
                $rules['name_en'] = 'required|max:63|unique:authors,name->en,' . $this->author->id;
                $rules['slug'] = 'unique:authors,slug,' . $this->author->id;
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
            // 'name_en.regex' => trans('admin_CRUD.legal_english_name'),
            'slug.unique' => trans('admin_CRUD.already_exist'),

            'intro_cn.max' => trans('admin_CRUD.max_limit_250_cn'),
            'intro_en.max' => trans('admin_CRUD.max_limit_1500_en'),
        ];
    }
}

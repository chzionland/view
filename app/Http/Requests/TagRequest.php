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
        'slug' => 'unique:tags,slug',
    ];

    protected function prepareForValidation()
    {
        $this->name_cn = trim($this->name_cn);
        $this->name_en = trim($this->name_en);

        $this->name_en = str_replace(" ", "_", $this->name_en);
        $this->name_en = Str::lower($this->name_en);
        $this->merge([
            'name_cn' => str_replace(' ', '', $this->name_cn),
            'name_en' => preg_replace('/[^a-zA-Z0-9\-\']/', '', $this->name_en),
            'name_en' => Str::lower($this->name_en),
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
                $rules['name_cn'] = 'required|max:15|unique:tags,name->cn,' . $this->tag->id;
                $rules['name_en'] = 'required|max:63|unique:tags,name->en,' . $this->tag->id;
                $rules['slug'] = 'unique:tags,slug,' . $this->tag->id;
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
            'slug.unique' => trans('admin_CRUD.already_exist'),
        ];
    }
}

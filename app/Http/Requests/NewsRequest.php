<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class NewsRequest extends FormRequest
{
    protected $rules = [
        'thumbnail' => 'nullable|url|max:255',

        'title_cn' => 'required|max:31|unique:posts,title->cn',
        'title_en' => 'required|max:127|unique:posts,title->en',
        'slug' => 'unique:posts,slug',

        'sub_title_cn' => 'max:31',
        'sub_title_en' => 'max:127',

        'details_cn' => 'max:2500',
        'details_en' => 'max:15000',
    ];

    protected function prepareForValidation()
    {
        $this->title_cn = trim($this->title_cn);
        $this->title_en = trim($this->title_en);

        $this->merge([
            'title_cn' => str_replace(' ', '', $this->title_cn),
            'title_en' => ucwords($this->title_en),
            'slug' => Str::slug($this->title_en),
            'sub_title_en' => ucwords($this->sub_title_en),
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
                $rules['title_cn'] = 'required|max:31|unique:posts,title->cn,' . $this->news->id;
                $rules['title_en'] = 'required|max:127|unique:posts,title->en,' . $this->news->id;
                $rules['slug'] = 'unique:posts,slug,' . $this->news->id;
                return $rules;
            }
        }
    }

    public function messages()
    {
        return [
            'thumbnail.url' => trans('admin_CRUD.must_url'),
            'thumbnail.max' => trans('admin_CRUD.max_limit_255'),

            'title_cn.required' => trans('admin_CRUD.is_must'),
            'title_en.required' => trans('admin_CRUD.is_must'),
            'title_cn.max' => trans('admin_CRUD.max_limit_31_cn'),
            'title_en.max' => trans('admin_CRUD.max_limit_127_en'),
            'title_cn.unique' => trans('admin_CRUD.already_exist'),
            'title_en.unique' => trans('admin_CRUD.already_exist'),
            'slug.unique' => trans('admin_CRUD.already_exist'),

            'sub_title_cn.max' => trans('admin_CRUD.max_limit_31_cn'),
            'sub_title_en.max' => trans('admin_CRUD.max_limit_127_en'),

            'details_cn.max' => trans('admin_CRUD.max_limit_2500_cn'),
            'details_en.max' => trans('admin_CRUD.max_limit_15000_en'),
        ];
    }
}

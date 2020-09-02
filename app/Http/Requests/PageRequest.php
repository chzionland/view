<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    protected $rules = [
        'thumbnail' => 'nullable|url|max:255',

        'title_cn' => 'required|max:31|unique:posts,title->cn',
        'title_en' => 'required|max:127|unique:posts,title->en',

        'sub_title_cn' => 'max:31',
        'sub_title_en' => 'max:127',

        'details_cn' => 'max:2500',
        'details_en' => 'max:15000',
    ];

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
                $rules['title_cn'] = 'required|max:31|unique:posts,title->cn,' . $this->page->id;
                $rules['title_en'] = 'required|max:31|unique:posts,title->en,' . $this->page->id;
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

            'sub_title_cn.max' => trans('admin_CRUD.max_limit_31_cn'),
            'sub_title_en.max' => trans('admin_CRUD.max_limit_127_en'),

            'details_cn.max' => trans('admin_CRUD.max_limit_2500_cn'),
            'details_en.max' => trans('admin_CRUD.max_limit_15000_en'),
        ];
    }
}

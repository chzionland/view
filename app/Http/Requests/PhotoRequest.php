<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
{
    protected $rules = [
        'image_url' => 'required|max:31',

        'intro_cn' => 'max:250',
        'intro_en' => 'max:1500',

        'tag_id' => 'required',
    ];

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
                $rules['image_url'] = 'is_empty';
                return $rules;
            }
        }
    }

    public function messages()
    {
        return [

            'img_url.required' => trans('admin_CRUD.is_must'),
            'img_url.max' => trans('admin_CRUD.max_limit_31'),
            // 'image.size',

            'intro_cn.max' => trans('admin_CRUD.max_limit_250_cn'),
            'intro_en.max' => trans('admin_CRUD.max_limit_1500_en'),

            'tag_id.required' => trans('admin_CRUD.is_must'),
        ];
    }
}

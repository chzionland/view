<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
{
    protected $rules = [
        'image_url' => 'required|max:31',
        // 'image' => 'size:max:500000',
        // 'image' => 'mimes:jpeg,png,bmp,gif,svg',
        'intro_cn' => 'max:250',
        'intro_en' => 'max:1500',
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
                $rules['image_url'] = 'nullable';
                return $rules;
            }
        }
    }

    public function messages()
    {
        return [
            'image_url.required' => trans('admin_CRUD.is_must'),
            'image_url.max' => trans('admin_CRUD.max_limit_31'),
            // 'image.size',

            'intro_cn.max' => trans('admin_CRUD.max_limit_250_cn'),
            'intro_en.max' => trans('admin_CRUD.max_limit_1500_en'),
        ];
    }
}

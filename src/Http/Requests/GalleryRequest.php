<?php

namespace Combindma\Gallery\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => ['required', 'file', 'mimes:gif,png,jpg,jpeg', 'dimensions:max_width=4000,max_height=4000', 'max:1024'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required','max:100'],
            'type' => ['required','max:50'],
            'weight' => ['required','max:100','min:1'],
            'description' => ['required'],
            'price' => ['required','max:255'],
            'grosir_price' => ['required','max:255'],
            'grosir_min' => ['required','max:255'],
            'stock' => ['required'],
            'photo' =>  ['required', 'image']
        ];
    }
}

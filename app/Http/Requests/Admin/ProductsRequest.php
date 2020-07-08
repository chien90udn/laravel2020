<?php

namespace App\Http\Requests\Admin;

use App\Rules\AlphaName;
use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title' => ['required','min:3'],
            'location' => ['required'],
            'city' => ['required'],
            'address' => ['required','min:3'],
            'price' => ['required','numeric'],
            'floor' =>['required'],
            'area_used' =>['required','numeric'],
            'description' => ['required','min:10','max:500'],
            'content' => ['required','min:50'],
            'picture.*'    => ['image','mimes:jpeg,jpg,png,gif|size:2048']

        ];
    }
}

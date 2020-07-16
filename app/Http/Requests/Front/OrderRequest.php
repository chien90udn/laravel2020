<?php

namespace App\Http\Requests\Front;

use App\Rules\AlphaName;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
    public function rules():array
    {
        return [
            'order_name' => ['required', 'string', 'max:255'],
            'order_address' => ['required', 'min:3'],
            'order_phone' => ['required', 'numeric'],
        ];
    }
}

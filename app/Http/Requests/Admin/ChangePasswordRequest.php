<?php

namespace App\Http\Requests\Admin;

use App\Rules\AlphaName;
use App\Rules\MatchOldPasswordAdmin;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_pass'=>['required',new MatchOldPasswordAdmin()],
            'new_pass'=>'required',
            'new_confirm_pass'=>'required|same:new_pass',
        ];
    }
}

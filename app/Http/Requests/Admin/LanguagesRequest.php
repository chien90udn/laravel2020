<?php
namespace App\Http\Requests\Admin;
use App\Rules\AlphaName;
use Illuminate\Foundation\Http\FormRequest;
class LanguagesRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', new AlphaName],
//            'short_name' => ['required', 'string', 'max:255', new AlphaName,'unique:languages,short_name'],
            'short_name' => ['required', 'string', 'max:255', new AlphaName],
            'default' => 'nullable',
            'picture' => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ];
    }
}

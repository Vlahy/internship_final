<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternRequest extends FormRequest
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
            'name' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string|unique:interns',
            'phone' => 'required|string',
            'cv' => 'required|string',
            'github' => 'required|string',
            'group_id' => 'required|string',
        ];
    }
}

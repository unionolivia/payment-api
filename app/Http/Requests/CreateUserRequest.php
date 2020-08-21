<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email' => 'required',
            'name' => 'required|string|max:50',
            'password' => 'required'
        ];
    }

    public function message(){
        return[
            'email.required' => 'Email is required.',
            'name.required' => 'Name is required',
            'password.required' => 'Password is required'
        ];
    }
    
}

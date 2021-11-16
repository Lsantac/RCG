<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            /*'email'=> 'required|email|unique:users',*/
            'email'=> 'required|email',
            'senha'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'email.required' => 'O campo Email é obrigatório!',
            'email.email' => 'Email inválido!',
            /*'email.unique'=>'Email já existente!',*/
            'senha.required'=>'Senha é obrigatória!'
             ];
        
    }
}

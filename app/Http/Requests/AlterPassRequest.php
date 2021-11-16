<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlterPassRequest extends FormRequest
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
            'senha'=>'required',
            'novasenha'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'senha.required'=>'Senha é obrigatória!',
            'novasenha.required'=>'Nova Senha é obrigatória!'
             ];
        
    }
    
}

<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterChecker extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"=>["required","max:50","unique:users"],
            "email"=>["required","regex:/(.+)@(.+)\.(.+)/i","unique:users"],
            "password"=>["required",Password::min(6)->letters()->numbers()->mixedCase()->symbols()->uncompromised(),"confirmed"],
            "password_confirmation"=>"required"

        ];
    }
    
    public function messages(): array
    {
        return [
            "name.required"=>"Name required",
            "name.max"=>"Name too long",
            "name.unique"=>"A Name már használatban van",
            "email.required"=>"Email required",
            "email.regex"=>"Email wrong format",
            "email.unique"=>"Az email már használatban van",
            "password.required"=>"Password required",
            "password.min"=>"Password too short",
            "password.letters"=>"Min one letter required",
            "password.numbers"=>"Min one number required",
            "password.mixed"=>"Upper and Lower case letters required",
            "password.symbols"=>"Min one special character required",
            "password.confirmed"=>"Confirm Password doesn't match",
            "password_confirmation.required"=>"Confirm Password required",

        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            "success"=>false,
            "message"=>"Adatbeviteli hiba",
            "data"=>$validator->errors()
        ]));
        
    }
}

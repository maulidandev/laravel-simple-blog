<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "name" => "required|max:191",
            "email" => "required|confirmed|email",
            "password" => $this->passwordRules(),
            "role" => "required|exists:roles,id",
        ];
    }

    private function passwordRules(){
        $rule = "confirmed|min:8";

        switch ($this->method()){
            case "POST":
                $rule = "$rule|required";
                break;
            case "PUT":
                $rule = "$rule|nullable";
                break;
        }

        return $rule;
    }
}

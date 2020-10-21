<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules = [
            "title" => $this->titleRules()
        ];

        return $rules;
    }

    private function titleRules(){
        $rule = "required|max:191|unique:categories";

        switch ($this->method()){
            case "PUT":
                $id = $this->route()->parameter("category");
                $rule = "$rule,title,$id,id";
        }

        return $rule;
    }
}

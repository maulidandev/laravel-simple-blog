<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            "title" => $this->titleRules(),
            "category_id" => "required|numeric",
            "content" => "required|max:1000",
            "new_category" => "required_if:category_id,-1"
        ];
    }

    private function titleRules(){
        $rule = "required|max:191|unique:posts";

        switch ($this->method()){
            case "PUT":
                $id = $this->route()->parameter("post");
                $rule = "$rule,title,$id,id";
        }

        return $rule;
    }

    public function messages()
    {
        return [
            "new_category.required_if" => "The new category field is required."
        ];
    }
}

<?php

namespace Humweb\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupSaveRequest extends FormRequest
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
            'name' => 'required',
            'slug' => 'required|unique:groups',
        ];

        if ($this->id) {
            $rules['slug'] .= ",slug,{$this->slug},slug";
        }

        return $rules;
    }
}

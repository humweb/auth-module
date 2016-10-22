<?php

namespace Humweb\Auth\Requests;

use Humweb\Http\Requests\Request;

class UserSaveRequest extends Request
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
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:users',
        ];

        if ($this->id) {
            $rules['email'] .= ',email,'.$this->id;
        }

        return $rules;
    }
}

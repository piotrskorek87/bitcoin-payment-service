<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CredentialsCreateRequest extends Request
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
            // 'email' => 'required|email',
            // 'name' => 'required',
            // 'address1' => 'required',
            // 'address2' => '',
            // 'city' => 'required',
            // 'postal_code' => 'required',
        ];
    }
}

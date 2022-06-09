<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'title' => 'required|string|unique:departments,title,'.$this->id,
            'email' => 'required|email|unique:departments,email,'.$this->id,
            'manager_id' => 'required|numeric|exists:users,id',
            'manager_of_manager_id' => 'nullable|numeric|exists:users,id',
        ];
    }
}

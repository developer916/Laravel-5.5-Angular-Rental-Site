<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;


class UserPasswordChangeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'oldpassword' => 'required|min:3',
            'newpassword' => 'required|min:3',
            'repeatnewpassword' => 'required|min:3',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
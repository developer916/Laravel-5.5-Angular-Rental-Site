<?php
/**
 * Created by PhpStorm.
 * User: cosinus
 * Date: 9/16/2015
 * Time: 1:37 AM
 */

namespace App\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
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
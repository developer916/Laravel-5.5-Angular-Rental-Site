<?php
    namespace App\Http\Requests\Admin;

    use Illuminate\Foundation\Http\FormRequest;

    class DocumentRequest extends FormRequest {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize () {
            return TRUE;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules () {
            /* return [
								 'start_date' => 'required',
								 'end_date' => 'required',
								 'rent' => 'required',
						 ];*/
            return [
                //
            ];
        }

    }

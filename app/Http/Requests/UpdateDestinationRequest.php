<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDestinationRequest extends FormRequest
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
            'destination_name' => 'required|max:35',
            'distance' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'destination_name.required' => 'Ime je neophodno, do 35 karaktera molim',
            'distance.required' => 'Udaljenost je neophodno unijeti i mora biti broj'
        ];
    }
}

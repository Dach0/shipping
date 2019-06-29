<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShipRequest extends FormRequest
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
            'boat_name' => 'required|max:35',
            'property_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'boat_name.required' => 'Ime brodića je neophodno, do 35 karaktera molim',
            'property_id.required' => 'Izaberite neku od opcija ili dodajte novu pa je selektujte'
        ];
    }
}

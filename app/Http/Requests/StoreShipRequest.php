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
            'selected_consumption' => 'required',
            'selected_crew_number' => 'required',
            'selected_max_speed' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'boat_name.required' => 'Ime brodića je neophodno, do 35 karaktera molim',
            'selected_consumption.required' => 'Izaberite neku od opcija ili dodajte novu pa je selektujte',
            'selected_crew_number.required' => 'Izaberite neku od opcija ili dodajte novu pa je selektujte',
            'selected_max_speed.required' => 'Izaberite neku od opcija ili dodajte novu pa je selektujte'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'order_name' => 'required|min:4|max:35',
            'destination_id' => 'required',
            'ship_id' => 'required',
            'price' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'order_name.required' => 'Ime poručioca ili ime porudžbine je neophodno, min 4 a max 35 karaktera',
            'destination_id.required' => 'Morate izabrati destinaciju',
            'ship_id.required' => 'Morate izabrati brod',
            'price.required' => 'Morate izračunati cijenu porudžbine'
        ];
    }

}
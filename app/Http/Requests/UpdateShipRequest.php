<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShipRequest extends FormRequest
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
            "boat_id" => "required",
            'boat_name' => 'required|max:35',
            'consumption' => 'required',
            'crew_number' => 'required',
            'max_speed' => 'required'
        ];
    }
}

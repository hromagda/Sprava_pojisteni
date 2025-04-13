<?php

namespace App\Http\Requests\Insurance;

use Illuminate\Foundation\Http\FormRequest;

class StoreInsuranceRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        return [
            'insurance_id' => 'required|exists:insurances,id', // Pojištění musí existovat
            'amount' => 'required|numeric|min:0', // Částka musí být číselná a větší nebo rovna 0
            'subject' => 'required|string|max:255', // Předmět pojištění je povinný a textový
            'valid_from' => 'required|date', // Platnost od je povinná a musí být platné datum
            'valid_to' => 'nullable|date|after:valid_from', // Platnost do musí být po datu platnosti od
            'note' => 'nullable|string|max:1000', // Poznámka je nepovinná, ale pokud je vyplněná, musí být textová a max 1000 znaků
        ];
    }

    /**
     * Get the custom attributes for the validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'insurance_id' => 'typ pojištění',
            'amount' => 'částka',
            'subject' => 'předmět pojištění',
            'valid_from' => 'platnost od',
            'valid_to' => 'platnost do',
            'note' => 'poznámka',
        ];
    }
}

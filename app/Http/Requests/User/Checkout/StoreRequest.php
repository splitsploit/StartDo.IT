<?php

namespace App\Http\Requests\User\Checkout;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // only logged in user can access this
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $expiredValidation = date('Y-m', time());

        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'. Auth::id().',id',
            'occupation' => 'required|string',
            // 'card_number' => 'required|numeric|digits_between:8,16',
            // 'expired' => 'required|date|date_format:Y-m|after_or_equal:'. $expiredValidation,
            // 'cvc' => 'required|numeric|digits:3',
            'phone' => 'required|string',
            'address' => 'required|string',
        ];
    }
}

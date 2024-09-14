<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update event') ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_name' => ['required', 'max:255'],
            'description' => ['required'],
            'date_open' => 'required|date|after_or_equal:today',
            'date_close' => 'required|date|after:date_open',
            'state' => ['required','max:255'],
            'city' => ['required','max:255'],
            'street' => ['required','max:255'],
            'barangay' => ['required','max:255'],
        ];
    }
}

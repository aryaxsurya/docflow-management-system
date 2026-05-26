<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
    return [
        'title' => 'required|string|max:255',
        'type' => 'nullable|string|max:100',
        'unit' => 'nullable|string|max:100',
        'description' => 'nullable|string',
        'effective_date' => 'nullable|date',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,txt|max:5120', // 5MB
    ];
    }

}

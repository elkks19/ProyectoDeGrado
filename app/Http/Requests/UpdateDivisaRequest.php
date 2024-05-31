<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Divisa;

class UpdateDivisaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'string|max:100',
            'simbolo' => 'string|max:10',
            'tasa' => 'numeric',
        ];
    }

    public function update(Divisa $divisa): Divisa
    {
        $divisa->update($this->validated());
        return $divisa;
    }
}

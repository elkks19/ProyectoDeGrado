<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Divisa;

class StoreDivisaRequest extends FormRequest
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
            'nombre' => 'required|string|max:100',
            'simbolo' => 'required|string|max:10',
            'tasa' => 'required|numeric',
        ];
    }

    public function save(): Divisa
    {
        $divisa = Divisa::create($this->validated());
        return $divisa;
    }
}

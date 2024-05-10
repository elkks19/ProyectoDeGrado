<?php

namespace App\Http\Requests;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'string|max:255',
            'descripcion' => 'string',
            'precio' => 'numeric'
        ];
    }

    public function update(Producto $producto): Producto
    {
        $producto->update($this->validated());
        return $producto;
    }
}

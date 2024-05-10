<?php

namespace App\Http\Requests;

use App\Models\Producto;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'string',
            'precio' => 'required|numeric'
        ];
    }

    public function save(): Producto
    {
        $producto = Producto::create($this->validated());
        return $producto;
    }
}

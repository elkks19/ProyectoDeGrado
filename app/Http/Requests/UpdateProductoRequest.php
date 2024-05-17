<?php

namespace App\Http\Requests;

use App\Models\Producto;
use App\Models\Categoria;
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
            'precio' => 'numeric',
            'relacionmxn' => 'array',
        ];
    }

    public function update(Producto $producto): Producto
    {
        $producto->update($this->validated());

        $ids = [];

        if ($this->relacionmxn){
            foreach ($this->relacionmxn as $nombre){
                $ids[] = Categoria::where('nombre', $nombre)->first()->id;
            }
        }

        $producto->categorias()->sync($ids);

        $producto->save();

        return $producto;
    }
}

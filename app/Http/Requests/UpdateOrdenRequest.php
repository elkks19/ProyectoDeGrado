<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Orden;
use App\Models\User;
use App\Models\Producto;
use App\Models\Divisa;
use App\Models\MetodoPago;
use Illuminate\Validation\Rule;

use App\EstadosOrden;
use App\EstadosPago;
use App\EstadosEnvio;

class UpdateOrdenRequest extends FormRequest
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
            'relacionmxn' => 'array', // PRODUCTOS

            'estado' => ['string', Rule::in(EstadosOrden::all())],
            'usuario' => 'string',
        ];
    }

    public function update(Orden $orden): Orden
    {
        $orden->update([
            'estado' => $this->estado,
        ]);

        if($this->usuario){
            $user = User::where('name', $this->usuario)->first()->id;
            $orden->user()->attach($user);
        }

        $ids = [];

        if ($this->relacionmxn){
            foreach ($this->relacionmxn as $nombre){
                $ids[] = Producto::where('nombre', $nombre)->first()->id;
            }

            $orden->productos()->sync($ids);
        }

        $orden->save();
        return $orden;
    }
}

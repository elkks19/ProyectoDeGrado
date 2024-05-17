<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Orden;
use App\Models\User;
use App\Models\Producto;
use App\Models\Divisa;
use App\Models\MetodoPago;

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
            'estado' => 'string,in:'.EstadosOrden::all(),
            'relacionmxn' => 'array', // PRODUCTOS

            'usuario' => 'string',

            'montoPago' => 'numeric',
            'fechaPago' => 'date',
            'estadoPago' => 'string,in:'.EstadosPago::all(),
            'divisaPago' => 'string',
            'metodoPago' => 'string',

            'direccionEnvio' => 'string',
            'fechaEnvio' => 'date',
            'fechaRecepcionEnvio' => 'date',
            'estadoEnvio' => 'string,in:'.EstadosEnvio::all(),
            'precioEnvio' => 'numeric',
        ];
    }

    public function update(Orden $orden): Orden
    {
        $orden->update(['estado' => $this->estado]);

        $orden->pago->update([
            'monto' => $this->montoPago,
            'fechaPago' => $this->fechaPago,
            'estado' => $this->estadoPago,
            'divisa' => Divisa::where('nombre', $this->divisa)->first()->id,
            'metodoPago' => MetodoPago::where('nombre', $this->metodoPago)->first()->id
        ]);

        $orden->envio->update([
            'direccion' => $this->direccionEnvio,
            'fechaEnvio' => $this->fechaEnvio,
            'fechaRecepcion' => $this->fechaRecepcionEnvio,
            'estado' => $this->estadoEnvio,
            'precio' => $this->precioEnvio,
        ]);

        $orden->usuario = User::where('name', $this->usuario)->first()->id;

        $ids = [];

        if ($this->relacionmxn){
            foreach ($this->relacionmxn as $nombre){
                $ids[] = Producto::where('nombre', $nombre)->first()->id;
            }
        }

        $orden->productos()->sync($ids);

        $orden->save();

        return $orden;
    }
}

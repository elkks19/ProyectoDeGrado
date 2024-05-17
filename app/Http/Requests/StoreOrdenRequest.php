<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Orden;
use App\Models\User;

use App\EstadosOrden;


class StoreOrdenRequest extends FormRequest
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
            'estado' => ['string', Rule::in(EstadosOrden::all())],
            'user' => 'required|string',
        ];
    }

    public function store(): Orden
    {
        $orden = Orden::create([
            'estado' => $this->estado,
            'user_id' => User::where('name', $this->user)->first()->id,
        ]);

        return $orden;
    }
}

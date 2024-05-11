<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\EstadosEnvio;

class Envio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'envios';

    protected $attributes = [
        'estado' => 'pendiente',
    ];

    protected $fillable = [
        'direccion',
        'fechaEnvio',
        'fechaRecepcion',
        'estado',
        'precio',
    ];

    public function casts(): array
    {
        return [
            'fechaEnvio' => 'datetime',
            'fechaRecepcion' => 'datetime',
            'estado' => EstadosEnvio::class
        ];
    }

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class);
    }
}

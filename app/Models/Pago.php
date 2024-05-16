<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\EstadosPago;

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos';

    protected $attributes = [
        'estado' => EstadosPago::PENDIENTE->value,
    ];

    protected $fillable = [
        'monto',
        'fechaPago',
        'estado',
    ];

    public function casts(): array
    {
        return [
            'fechaPago' => 'datetime',
            'estado' => EstadosPago::class,
        ];
    }

    public function orden(): HasOne
    {
        return $this->hasOne(Orden::class);
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class);
    }

    public function divisa(): BelongsTo
    {
        return $this->belongsTo(Divisa::class);
    }
}

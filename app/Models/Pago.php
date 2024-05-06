<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos';

    protected $attributes = [
        'estado' => 'pendiente',
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
        ];
    }

    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class);
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

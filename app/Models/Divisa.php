<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Divisa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'divisas';

    protected $fillable = [
        'nombre',
        'simbolo',
        'tasa',
    ];

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'fechaNacimiento',
        'ci'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'fechaNacimiento' => 'date',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ordenes(): HasMany
    {
        return $this->hasMany(Orden::class);
    }
}

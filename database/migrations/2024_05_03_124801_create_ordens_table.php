<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Pago;
use App\Models\Envio;
use App\Models\User;

use App\EstadosOrden;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', EstadosOrden::all())->default(EstadosOrden::PENDIENTE->value);
            $table->foreignIdFor(Pago::class)->constrained('pagos', 'id');
            $table->foreignIdFor(Envio::class)->constrained('envios', 'id');
            $table->foreignIdFor(User::class)->constrained('users', 'id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};

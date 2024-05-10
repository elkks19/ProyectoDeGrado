<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Pago;
use App\Models\Envio;

use App\EstadosOrden;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->enum('estado', ['pendiente', 'procesando', 'enviado', 'entregado'])->default(EstadosOrden::PENDIENTE->value);
            $table->foreignIdFor(Pago::class)->constrained('pagos', 'id');
            $table->foreignIdFor(Envio::class)->constrained('envios', 'id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};

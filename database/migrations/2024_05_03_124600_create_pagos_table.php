<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Divisa;
use App\Models\MetodoPago;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->float('monto', 2);
            $table->dateTime('fechaPago')->nullable();
            $table->string('estado', 20);
            $table->foreignIdFor(Divisa::class)->nullable()->constrained('divisas', 'id');
            $table->foreignIdFor(MetodoPago::class)->nullable()->constrained('divisas', 'id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};

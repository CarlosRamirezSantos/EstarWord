<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropiedadTable extends Migration
{
    public function up()
    {
        Schema::create('piloto_nave', function (Blueprint $table) {
            $table->id();
            $table->foreignId('piloto_id')->constrained('pilotos')->onDelete('cascade');
            $table->foreignId('nave_id')->constrained('naves')->onDelete('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->timestamps();
            $table->unique(['piloto_id', 'nave_id', 'fecha_inicio'], 'piloto_nave_unico');
        });
    }

    public function down()
    {
        Schema::dropIfExists('piloto_nave');
    }
}

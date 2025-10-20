<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanetaTable extends Migration
{
    public function up()
    {
        Schema::create('planetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('periodo_rotacion')->nullable();
            $table->bigInteger('poblacion')->nullable();
            $table->string('clima')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('planetas');
    }
}

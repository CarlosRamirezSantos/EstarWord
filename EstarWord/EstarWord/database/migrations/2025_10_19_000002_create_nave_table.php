<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNaveTable extends Migration
{
    public function up()
    {
        Schema::create('naves', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('modelo')->nullable();
            $table->integer('tripulacion')->nullable();
            $table->integer('pasajeros')->nullable();
            $table->string('clase_nave')->nullable();
            $table->foreignId('planeta_id')->constrained('planetas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('naves');
    }
}

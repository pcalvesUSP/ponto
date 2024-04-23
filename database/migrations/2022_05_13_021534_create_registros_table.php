<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('codpes');
            $table->string('type'); // in or out
            $table->string('image');
            $table->string('status')->default('valido')->change();
            $table->string('motivo')->nullable();
            $table->text('justificativa')->nullable();
            $table->text('analise')->nullable();
            $table->string('codpes_analise')->nullable();

            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')->references('id')->on('places');

            /*foreach(Registro::all() as $registro){
                $registro->status = 'válido';
                $registro->save();
            }*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros');
    }
}

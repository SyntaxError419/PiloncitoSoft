<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->foreignId('id_menu')->references('id')->on('menus')->onDelete('cascade');
            $table->string('url')->nullable();
            $table->string('metodo')->nullable();
            $table->boolean('igualdad')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();

        });
        DB::table('permisos')->insert([
            ['descripcion'=>'vista general','id_menu'=>'1','url'=>'/home','metodo'=>'GET','igualdad'=>'1'],
            ['descripcion'=>'vista roles','id_menu'=>'2','url'=>'/roles','metodo'=>'GET','igualdad'=>'0'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}

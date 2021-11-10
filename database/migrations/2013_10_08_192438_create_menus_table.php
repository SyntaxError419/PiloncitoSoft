<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('url')->nullable();
            $table->string('icono')->nullable();
            $table->boolean('estado')->nullable()->default(true);
            $table->timestamps();
        });
        DB::table('menus')->insert([
         ['nombre'=>'Inicio','url'=>'/home','icono'=>'i'],
         ['nombre'=>'Roles','url'=>'/roles','icono'=>'i'],
         ['nombre'=>'Usuarios','url'=>'/usuarios','icono'=>'i']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}

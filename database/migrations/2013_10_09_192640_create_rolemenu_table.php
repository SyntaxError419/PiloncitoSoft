<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolemenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rolemenu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rol')->references('id')->on('roles')->onDelete('cascade');
            $table->foreignId('id_menu')->references('id')->on('menus')->onDelete('cascade');
            $table->timestamps();
        });
        DB::table('rolemenu')->insert([
            ['id_rol'=>'1','id_menu'=>'1'],
            ['id_rol'=>'1','id_menu'=>'2'],
            ['id_rol'=>'2','id_menu'=>'1'],
            ['id_rol'=>'2','id_menu'=>'2'],
            ['id_rol'=>'3','id_menu'=>'1'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rolemenu');
    }
}

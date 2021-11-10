<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolepermiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rolepermi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_rol')->references('id')->on('roles')->onDelete('cascade');
            $table->foreignId('id_permi')->references('id')->on('permisos')->onDelete('cascade');
            $table->timestamps();
        });
        DB::table('rolepermi')->insert([
            ['id_rol'=>'1','id_permi'=>'1'],
            ['id_rol'=>'1','id_permi'=>'2'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rolepermi');
    }
}

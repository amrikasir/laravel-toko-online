<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SimpleProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // new table for simple program
        // id, faktur, tanggal, barang, harga, qty, total
        Schema::create('simple_program', function (Blueprint $table) {
            $table->id();
            $table->string('faktur');
            $table->date('tanggal');
            $table->string('barang');
            $table->integer('harga');
            $table->integer('qty');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

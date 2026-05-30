<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material', function (Blueprint $table) {
            $table->id('id');
            $table->string('nama_barang');
            $table->string('satuan');
            $table->integer('harga');
            $table->string('supplier');
            $table->string('deskripsi');
            $table->unsignedBigInteger('id_user'); 
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');   
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material');
    }
};
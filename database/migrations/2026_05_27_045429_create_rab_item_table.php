<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rab_item', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_rab');
            $table->unsignedBigInteger('parent_id')->nullable(); 
            $table->enum('tipe', ['kategori', 'item', 'sub-rincian']);
            $table->unsignedBigInteger('id_material')->nullable(); 
            $table->string('deskripsi_pekerjaan');
            $table->integer('qty')->nullable();
            $table->integer('harga_awal')->nullable();
            $table->integer('subtotal')->nullable();
            $table->timestamps();

            $table->foreign('id_rab')->references('id')->on('rabs')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('rab_item')->onDelete('cascade');
            $table->foreign('id_material')->references('id')->on('material')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rab_item');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('material', function (Blueprint $table) {
    $table->id();

    $table->string('nama_barang');
    $table->text('deskripsi')->nullable();

    $table->string('satuan', 50);
    $table->integer('jumlah')->default(0);

    $table->decimal('harga', 15, 2);

    $table->string('supplier');

    $table->foreignId('id_user')
        ->constrained('users')
        ->onDelete('cascade');

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('material');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            // Kode supplier (opsional)
            $table->string('kode_supplier')->unique()->nullable();

            // Nama supplier
            $table->string('nama_supplier');

            // Kontak
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();

            // PIC (Person In Charge)
            $table->string('pic')->nullable();

            // Alamat
            $table->text('alamat')->nullable();

            // Status aktif
            $table->boolean('is_active')->default(true);

            // Catatan tambahan
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
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
       Schema::create('material_requests', function (Blueprint $table) {
    $table->id();

    $table->string('nama_material');

    $table->text('deskripsi')->nullable();

    $table->string('satuan', 50);

    $table->enum('status', [
        'pending',
        'approved',
        'rejected'
    ])->default('pending');

    $table->text('catatan_purchasing')->nullable();

    $table->foreignId('requested_by')
        ->constrained('users')
        ->onDelete('cascade');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_request');
    }
};

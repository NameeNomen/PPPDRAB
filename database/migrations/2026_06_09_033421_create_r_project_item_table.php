<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('r_project_items', function (Blueprint $table) {
    $table->id();

    $table->foreignId('r_project_id')
        ->constrained('r_project')
        ->cascadeOnDelete();

    $table->string('nama_item');

    $table->integer('qty');

    $table->string('satuan', 50);

    $table->text('spesifikasi_klien')->nullable();

    $table->boolean('is_calculated')->default(false);

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('r_project_items');
    }
};
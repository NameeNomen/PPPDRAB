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
       Schema::create('material_suppliers', function (Blueprint $table) {
    $table->id();

    $table->foreignId('material_id')
        ->constrained('material')
        ->cascadeOnDelete();

    $table->foreignId('supplier_id')
        ->constrained('suppliers')
        ->cascadeOnDelete();

    // Harga material dari supplier ini
    $table->decimal('harga', 35, 2);

    // Estimasi pengiriman
    $table->unsignedInteger('lead_time_hari')->default(0);

    // Supplier utama
    $table->boolean('is_preferred')->default(false);

    $table->text('catatan')->nullable();

    $table->timestamps();

    // Hindari duplikasi supplier untuk material yang sama
$table->unique(['material_id', 'supplier_id'], 'ms_unique');
});
    }
    public function down(): void
    {
        Schema::dropIfExists('material_suppliers');
    }
};
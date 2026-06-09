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
       Schema::create('r_project_item_materials', function (Blueprint $table) {
    $table->id();

    $table->foreignId('project_item_id')
        ->constrained('r_project_items')
        ->cascadeOnDelete();

    $table->foreignId('material_id')
        ->nullable()
        ->constrained('material')
        ->nullOnDelete();

    $table->decimal('qty', 15, 2);

    $table->string('satuan', 50);

    $table->enum('status_kesesuaian', [
        'exact_match',
        'similar_match',
        'not_match'
    ])->default('exact_match');

    $table->text('catatan_engineering')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_project_item_material');
    }
};

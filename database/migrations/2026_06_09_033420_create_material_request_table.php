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
    
    // 1. KONTEKS: Material ini diminta buat RAB proyek mana?
    $table->foreignId('r_project_id')->nullable()->constrained('r_project')->onDelete('cascade');
    
    $table->string('nama_material');
    $table->text('deskripsi')->nullable();
    
    // 2. KUANTITAS: Purchasing butuh tau butuhnya berapa buat nego harga
    $table->decimal('estimasi_kebutuhan', 10, 2)->nullable();
    $table->string('satuan', 50);
    
    // 3. DEADLINE: Biar Purchasing tau kapan barangnya harus ready
    $table->date('target_waktu_dibutuhkan')->nullable();

    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->text('catatan_purchasing')->nullable();
    
    // 4. CLOSING LOOP: Kalau disetujui, link ke ID material aslinya yang udah dibuat purchasing
    $table->foreignId('id_material_terdaftar')->nullable()->constrained('materials')->onDelete('set null');
    
    $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');
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

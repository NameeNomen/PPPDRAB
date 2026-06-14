<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biddings', function (Blueprint $table) {
    $table->id();

    // Relasi
    $table->foreignId('id_r_project')->constrained('r_project')->cascadeOnDelete();
    $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();

    // Identitas Dokumen
    $table->string('no_penawaran')->unique();
    $table->date('tgl_penawaran');
    $table->string('perihal');

    // Tujuan Penawaran
    $table->string('kepada');          // Nama perusahaan klien
    $table->string('up')->nullable();  // Attn / PIC

    // Isi Penawaran
    $table->longText('surat_pengantar')->nullable();
    $table->longText('catatan')->nullable();

    // Ketentuan Komersial
    $table->string('term_of_payment');
    $table->integer('masa_berlaku');      // hari
    $table->integer('waktu_pengerjaan')->nullable(); // hari
    $table->string('garansi')->nullable();
    $table->bigInteger('harga_dasar');      // dari RAB
$table->bigInteger('total_penawaran');  // diisi Marketing


    // Status Workflow
    $table->enum('status_bidding', [
        'draft',
        'pending',
        'approved',
        'revision',
        'sent',
        'won',
        'lost',
        'rejected'
    ])->default('draft');

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('biddings');
    }
};
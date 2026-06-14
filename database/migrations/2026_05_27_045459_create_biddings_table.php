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

            // Relasi (Tetap simpan ID biar bisa dilacak ke induknya)
            $table->foreignId('id_r_project')->constrained('r_project')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();

            // Snapshot Data (Penting biar data historis tidak berubah)
            $table->string('nama_pelanggan_snapshot');
            $table->string('pic_pelanggan_snapshot')->nullable();

            // Identitas Dokumen
            $table->string('no_penawaran')->unique();
            $table->date('tgl_penawaran');
            $table->string('perihal');

            // Isi Penawaran
            $table->longText('surat_pengantar')->nullable();
            $table->longText('catatan')->nullable();

            // Ketentuan Komersial
            $table->string('term_of_payment');
            $table->integer('masa_berlaku'); 
            $table->integer('waktu_pengerjaan')->nullable();
            $table->string('garansi')->nullable();
            
            // Harga (Snapshot dari RAB, pakai decimal biar presisi)
            $table->decimal('harga_dasar', 20, 2);      
            $table->decimal('total_penawaran', 20, 2);

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
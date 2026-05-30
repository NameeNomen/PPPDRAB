<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('r_project', function (Blueprint $table) {
            $table->id(); // INI ID INTERNAL (Auto Increment)
            $table->string('request_no')->unique(); // INI NOMOR UNTUK KLIEN
            $table->unsignedBigInteger('id_user'); 
            $table->unsignedBigInteger('category_id')->nullable(); // Relasi ke Kategori
            
            $table->string('nama_pelanggan');
            $table->string('pic_pelanggan');
            $table->string('no_hp');
            $table->text('deskripsi_proyek');
            $table->date('target_waktu');
            $table->bigInteger('estimasi_budget');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status_proyek', ['waiting_rab', 'rab_approved', 'bidding_process', 'won', 'lost'])->default('waiting_rab');
            $table->text('alamat');
            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('category_id')->references('id')->on('project_categories')->onDelete('set null'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('r_project');
    }
};
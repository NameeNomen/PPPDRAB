<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('r_project', function (Blueprint $table) {
            $table->id();
            $table->string('request_no')->unique();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete(); 
            $table->string('nama_projek'); 
            $table->string('nama_pelanggan'); 
            $table->string('pic_pelanggan')->nullable(); 
            $table->string('no_hp')->nullable(); 
            $table->text('deskripsi_proyek')->nullable(); 
            $table->date('target_waktu')->nullable(); 
            
            // Dinaikkan menjadi 20 digit agar tidak overflow saat input angka besar
            $table->decimal('estimasi_budget', 20, 2)->nullable(); 
            
            // Sinkronisasi enum priority (wajib lowercase)
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); 
            
            $table->text('alamat')->nullable(); 
            
            // Menambahkan 'pending' ke dalam daftar aman enum
            $table->enum('status_proyek', [
                'pending',
                'draft',
                'bidding',
                'approved',
                'rejected',
                'on_progress',
                'completed'
            ])->default('pending');

            $table->foreignId('category_id')->nullable()->constrained('project_categories')->nullOnDelete();
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('r_project');
    }
};
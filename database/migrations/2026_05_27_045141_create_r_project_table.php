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

            $table->foreignId('id_user')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nama_pelanggan');
            $table->string('pic_pelanggan')->nullable();
            $table->string('no_hp')->nullable();

            $table->text('deskripsi_proyek')->nullable();

            $table->date('target_waktu')->nullable();

            $table->decimal('estimasi_budget', 15, 2)->nullable();

            $table->enum('priority', ['low', 'medium', 'high'])
                ->default('medium');

            // alamat + maps
            $table->text('alamat')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->enum('status_proyek', [
                'draft',
                'bidding',
                'approved',
                'rejected',
                'on_progress',
                'completed'
            ])->default('draft');

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('project_categories')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('r_project');
    }
};
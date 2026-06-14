<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_commits', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_r_project'); // Siapa pengomit / direktur yang merevisi
            $table->unsignedBigInteger('id_rab')->nullable(); // Terisi jika dokumen terkait adalah RAB
            $table->unsignedBigInteger('id_bidding')->nullable(); // Terisi jika dokumen terkait adalah Bidding
            $table->unsignedBigInteger('id_user')->nullable(); // Terisi jika dokumen terkait adalah Bidding
            $table->enum('jenis_aksi', ['created', 'updated', 'submitted', 'revised', 'approved']); 
            $table->text('komentar_commit'); // Isi komentar revisi atau alasan komitan data
             $table->decimal('total_penawaran', 20, 2)->default(0);
            $table->string('user_name');
            $table->json('snapshot_data')->nullable(); // Isi komentar revisi atau alasan komitan data

            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_r_project')->references('id')->on('r_project')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_rab')->references('id')->on('rabs')->onDelete('cascade');
            $table->foreign('id_bidding')->references('id')->on('biddings')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_commits');
    }
};
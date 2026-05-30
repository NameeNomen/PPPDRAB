<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biddings', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_r_project');
            $table->string('nama_perusahaan');
            $table->string('term_of_payment');
            $table->integer('masa_berlaku');
            $table->string('no_penawaran');
            $table->date('tgl_penawaran');
            $table->string('surat_pengantar')->nullable();
            $table->string('alamat_perusahaan');
            $table->integer('total_penawaran');
            $table->enum('status_bidding', ['draft', 'sent', 'won', 'lost','approved','revisi','rejected'])->default('draft');
            $table->string('email_perusahaan');
            $table->unsignedBigInteger('id_user'); 
            $table->timestamps();

            $table->foreign('id_r_project')->references('id')->on('r_project')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biddings');
    }
};
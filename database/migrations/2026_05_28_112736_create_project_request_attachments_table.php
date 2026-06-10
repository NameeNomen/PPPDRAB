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
       Schema::create('project_request_attachments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('r_project_id'); // Menghubungkan file ke request yang mana
        $table->string('file_name'); // Nama asli file (proposal.pdf)
        $table->string('file_path'); // Alamat simpan di storage (public/attachments/xyz.pdf)
        $table->string('file_type'); 
        $table->enum('attachment_category', [
    'reference_image',
    'location_photo',
    'technical_drawing',
    'proposal',
    'other'
])->default('other');
        $table->timestamps();

        // Kalau request dihapus, file ikut kehapus dari database
        $table->foreign('r_project_id')->references('id')->on('r_project')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_request_attachments');
    }
};

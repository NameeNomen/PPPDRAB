<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ingat, best practice Laravel itu nama tabelnya jamak (plural)
        Schema::create('r_project_items', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel Header lu (r_project)
            $table->unsignedBigInteger('r_project_id'); 
            
            // Data mentah dari klien
            $table->string('nama_item'); // Contoh: "Conveyor Belt" atau "Pemasangan Pipa"
            $table->text('spesifikasi_klien')->nullable(); // Curhatan klien soal spek barangnya
            $table->integer('qty');
            $table->string('satuan', 50); // pcs, lot, unit, meter
            
            // LOGIKA ERP: Flagging buat nandain status kalkulasi RAB
            // Biar lu gampang nge-filter di frontend mana item yang masih butuh dihitung
            $table->boolean('is_calculated')->default(false); 
            
            $table->timestamps();

            // Foreign Key: Kalau proyeknya dihapus, itemnya ikut lenyap (Cascade)
            $table->foreign('r_project_id')
                  ->references('id')->on('r_project')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('r_project_items');
    }
};

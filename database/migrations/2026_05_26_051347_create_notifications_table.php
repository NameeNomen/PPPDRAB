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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users'); // Target user yang dapet notif (Marketing)
            $table->string('judul');
            $table->text('pesan');
            $table->string('url_tujuan')->nullable(); // Biar pas di-klik langsung ngarah ke halamannya
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->timestamp('read_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

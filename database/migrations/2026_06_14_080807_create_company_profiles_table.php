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
        Schema::create('company_profiles', function (Blueprint $table) { $table->id(); $table->string('nama_perusahaan'); $table->text('alamat'); $table->string('email')->nullable(); $table->string('telepon')->nullable(); $table->string('website')->nullable(); $table->string('npwp')->nullable(); $table->string('direktur')->nullable(); $table->string('jabatan_penandatangan') ->default('Direktur'); $table->string('logo')->nullable(); $table->string('iso_logo')->nullable(); $table->string('stempel')->nullable(); $table->timestamps(); });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profile');
    }
};

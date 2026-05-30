<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rabs', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_r_project');
            $table->string('no_boq');
            $table->date('tgl_boq');
            $table->biginteger('overhead_cost');
            $table->biginteger('grand_total')->default(0);
            $table->enum('status_rab', ['draft', 'pending', 'revision', 'approved'])->default('draft');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_r_project')->references('id')->on('r_project')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');   
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rabs');
    }
};
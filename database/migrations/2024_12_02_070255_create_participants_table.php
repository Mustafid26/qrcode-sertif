<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Nama participant
            $table->string('email'); // Email participant
            $table->enum('position', ['Moderator', 'Pembicara', 'Peserta', 'Panitia']); // Posisi atau peran
            $table->unsignedBigInteger('certificate_id')->nullable(); 
            $table->string('certificate_number');
            $table->string('qr_code_path')->nullable();
            $table->timestamps(); 
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
};

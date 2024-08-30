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
        Schema::create('ms_departemen', function (Blueprint $table) {
            $table->id('ms_departeman_id');
            $table->uuid('ms_departeman_uuid');
            $table->foreignId('ms_komparteman_id')
            ->references('ms_komparteman_id')
            ->on('ms_kompartemen') // Automatically references 'id' column
            ->onDelete('cascade');
            $table->string('Kode_kompartemen');
            $table->string('kode_departemen');
            $table->string('nama_departemen');
            $table->timestamps();
            $table->softDeletes();
            // $table->createdUpdatedBy();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_departemen');
    }
};

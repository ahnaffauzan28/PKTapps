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
        Schema::create('ms_kompartemen', function (Blueprint $table) {
            $table->id('ms_komparteman_id');
            $table->uuid('ms_komparteman_uuid');
            $table->string('Kode_kompartemen');
            $table->string('nama_kompartemen');
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
        Schema::dropIfExists('ms_kompartemen');
    }
};

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
        Schema::create('tr_badgeforms', function (Blueprint $table) {
            $table->id('tr_badgeform_id');
            $table->uuid('tr_badgeform_uuid');
            $table->string('email');
            $table->string('nama');
            $table->string('instansi');
            $table->string('handphone');
            $table->string('keperluan');
            $table->string('tujuan');
            $table->foreignId('ms_komparteman_id')
            ->references('ms_komparteman_id')
            ->on('ms_kompartemen') // Automatically references 'id' column
            ->onDelete('cascade');
            $table->foreignId('ms_departeman_id')
            ->references('ms_departeman_id')
            ->on('ms_departemen') // Automatically references 'id' column
            ->onDelete('cascade');
            $table->string('durasi');
            $table->Date('tanggal');
            $table->string('jpemohon');
            $table->enum('status',[0, 1, 2, 3 ,4 ,5 ,6 ])->default(0);
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('tr_badgeforms');
    }
};

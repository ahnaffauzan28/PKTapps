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
        Schema::create('tr_tambahidentitas', function (Blueprint $table) {
            $table->id('tr_tambahidentitum_id'); // Automatic 'id' column (primary key)
            $table->uuid('tr_tambahidentitum_uuid')->unique(); // Unique UUID column
            $table->foreignId('tr_badgeform_id')
                  ->references('tr_badgeform_id')
                  ->on('tr_badgeforms') // Automatically references 'id' column
                  ->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->enum('status',['approved', 'waiting', 'rejected'])->default('waiting');
            $table->timestamps();
            $table->softDeletes(); // Soft delete column
            // If needed, manually add created_by and updated_by columns
            // $table->unsignedBigInteger('created_by')->nullable();
            // $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_tambahidentitas');
    }
};

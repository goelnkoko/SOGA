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
        Schema::create('friend', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user1_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('user2_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['ACTIVE', 'BLOCKED', 'SUSPENDED']);
            $table->timestamp('connection_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend');
    }
};

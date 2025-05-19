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
        Schema::dropIfExists('comments');
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment')->nullable();
            $table->string('guid')->nullable();
            $table->string('token')->nullable();
            $table->string('user_id')->nullable();
            // $table->foreignId('user_id')->nullable()->constrained('comments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment');
    }
};

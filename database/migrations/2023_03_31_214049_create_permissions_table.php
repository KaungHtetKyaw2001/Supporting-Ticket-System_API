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
        Schema::dropIfExists('permissions');
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('permission')->nullable();
            $table->string('assignee_id')->nullable();
            $table->string('assignee_name')->nullable();
            $table->string('guid')->nullable();
            $table->string('token')->nullable();
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};

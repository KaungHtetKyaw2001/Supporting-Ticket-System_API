<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrioritiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('priority')->nullable();
            $table->string('assignee_id')->nullable();
            $table->string('assignee_name')->nullable();
            $table->string('guid')->nullable();
            $table->string('token')->nullable();
            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->timestamps();
        });

        Schema::table('priorities', function (Blueprint $table) {
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('priorities', function (Blueprint $table) {
        //     $table->dropForeign(['ticket_id']);
        // });

        // Schema::dropIfExists('priorities');
    }
}

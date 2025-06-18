<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaddockAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paddock_assignments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('animal_id')->constrained()->onDelete('cascade');
    $table->foreignId('paddock_id')->constrained()->onDelete('cascade');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->string('moved_by');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paddock_assignments');
    }
}

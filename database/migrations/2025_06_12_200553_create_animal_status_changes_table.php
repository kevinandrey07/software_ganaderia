<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalStatusChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_status_changes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('animal_id')->constrained()->onDelete('cascade');
    $table->foreignId('old_status_id')->constrained('animal_statuses')->onDelete('cascade');
    $table->foreignId('new_status_id')->constrained('animal_statuses')->onDelete('cascade');
    $table->timestamp('changed_at');
    $table->string('changed_by');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animal_status_changes');
    }
}

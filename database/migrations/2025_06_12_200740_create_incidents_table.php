<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('animal_id')->constrained()->onDelete('cascade');
    $table->enum('type', ['accidente', 'enfermedad']);
    $table->text('description');
    $table->string('reported_by');
    $table->date('date');
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}

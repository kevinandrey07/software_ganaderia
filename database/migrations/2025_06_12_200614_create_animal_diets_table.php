<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalDietsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_diets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('animal_id')->constrained()->onDelete('cascade');
    $table->foreignId('diet_id')->constrained()->onDelete('cascade');
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->text('notes')->nullable();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animal_diets');
    }
}

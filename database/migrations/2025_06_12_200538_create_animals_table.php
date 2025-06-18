<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique();
    $table->string('name')->nullable();
    $table->enum('sex', ['macho', 'hembra']);
    $table->date('birth_date');
    $table->foreignId('breed_id')->constrained()->onDelete('cascade');
    $table->foreignId('status_id')->constrained('animal_statuses')->onDelete('cascade');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}

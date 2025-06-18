<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milk_productions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('animal_id')->constrained()->onDelete('cascade');
    $table->date('date');
    $table->float('liters', 8, 2);
    $table->text('notes')->nullable();
    $table->timestamp('created_at')->useCurrent();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milk_productions');
    }
}

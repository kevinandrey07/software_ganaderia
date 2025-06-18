<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apprentice_id');
            $table->text('description');
            $table->enum('status', ['pendiente', 'realizada', 'no realizada'])->default('pendiente');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('apprentice_id')
                  ->references('id')
                  ->on('apprentices')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

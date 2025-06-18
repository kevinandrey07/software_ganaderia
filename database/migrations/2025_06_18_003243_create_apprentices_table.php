<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprenticesTable extends Migration
{
    public function up()
    {
        Schema::create('apprentices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->date('birth_date');
            $table->enum('gender', ['M', 'F', 'O']);
            $table->unsignedBigInteger('training_record_id');
            $table->enum('stage', ['lectiva', 'productiva']);
            $table->timestamps();

            $table->foreign('training_record_id')
                  ->references('id')
                  ->on('training_records')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('apprentices');
    }
}

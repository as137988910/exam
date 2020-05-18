<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('paper_id')->unsigned();
            $table->foreign('paper_id')->references('id')->on('papers');
            $table->integer('sequence');
            $table->integer('specices');
            $table->text('description');
            $table->string('a');
            $table->string('b');
            $table->string('c');
            $table->string('d');
            $table->integer('score');
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
        Schema::dropIfExists('problems');
    }
}

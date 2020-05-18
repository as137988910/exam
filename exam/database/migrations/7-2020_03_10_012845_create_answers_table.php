<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stu_id')->unsigned();
            $table->bigInteger('problem_id')->unsigned();
            $table->foreign('stu_id')->refrences('id')->on('students');
            $table->foreign('problem_id')->refrences('id')->on('problems');
            $table->integer('specices');
            $table->string('a');
            $table->string('b');
            $table->string('c');
            $table->string('d');
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
        Schema::dropIfExists('answers');
    }
}

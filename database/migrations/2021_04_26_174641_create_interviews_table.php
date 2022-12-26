<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("advisor_id");
            $table->unsignedBigInteger("interview_question_id");
            $table->text("answer");
            $table->boolean("publication_status");
            $table->timestamps();

            $table->foreign("advisor_id")->references("id")->on("advisors")->cascadeOnDelete();
            $table->foreign("interview_question_id")->references("id")->on("interview_questions")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}

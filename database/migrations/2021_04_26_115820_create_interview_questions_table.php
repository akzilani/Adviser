<?php

use App\InterviewQuestion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_questions', function (Blueprint $table) {
            $table->id();
            $table->string("question");
            $table->boolean("publication_status");
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("created_by")->references("id")->on("admins");
            $table->foreign("updated_by")->references("id")->on("admins");
        });
        $this->insertQuestion();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_questions');
    }

    /**
     * Migrate Interview Question
     */
    protected function insertQuestion(){
        InterviewQuestion::insert([
            'id'                    => 1,
            "question"              => "Can you tell us a bit about your background?",
            "publication_status"    => true,
        ]);
        InterviewQuestion::insert([
            'id'                    => 2,
            "question"              => "Who should be seeking advice?",
            "publication_status"    => true,
        ]);
        InterviewQuestion::insert([
            'id'                    => 3,
            "question"              => "Why should they seek advice over making a decision themselves?",
            "publication_status"    => true,
        ]);
        InterviewQuestion::insert([
            'id'                    => 4,
            "question"              => "What financial pitfalls might people come across?",
            "publication_status"    => true,
        ]);
        InterviewQuestion::insert([
            'id'                    => 5,
            "question"              => "Can you explain the process of receiving financial advice?",
            "publication_status"    => true,
        ]);
        InterviewQuestion::insert([
            'id'                    => 6,
            "question"              => "Do you find that a client's initial objective changes following their first meeting?",
            "publication_status"    => true,
        ]);
        InterviewQuestion::insert([
            'id'                    => 7,
            "question"              => "How much does advice cost?",
            "publication_status"    => true,
        ]);
        InterviewQuestion::insert([
            'id'                    => 8,
            "question"              => "Isn't it a catch-22 situation to be spending money to find out how to save money?",
            "publication_status"    => true,
        ]);
        InterviewQuestion::insert([
            'id'                    => 9,
            "question"              => "How often do you review the financial situation with your clients?",
            "publication_status"    => true,
        ]);
    }
}

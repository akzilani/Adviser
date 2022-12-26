<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisorQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advisor_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("advisor_id")->nullable();            
            $table->unsignedBigInteger("service_offer_id")->nullable(); 
            $table->string("question")->nullable();           
            $table->text("answer")->nullable();           
            $table->enum("visibility",['public', 'private'])->default('public');
            $table->boolean("publication_status")->default(false);
            
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("service_offer_id")->references("id")->on("service_offers");
            $table->foreign("created_by")->references("id")->on("admins");
            $table->foreign("updated_by")->references("id")->on("admins");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advisor_questions');
    }
}

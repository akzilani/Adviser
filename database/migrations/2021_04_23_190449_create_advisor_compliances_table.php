<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisorCompliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advisor_compliances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("advisor_id")->nullable();  
            $table->text("compliance"); 
            $table->timestamps();
            
            $table->foreign("advisor_id")->references("id")->on("advisors")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advisor_compliances');
    }
}

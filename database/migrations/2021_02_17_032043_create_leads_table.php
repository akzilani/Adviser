<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advisor_id')->nullable();
            $table->unsignedBigInteger('fund_size_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('post_code')->nullable();
            $table->text('question')->nullable();            
            $table->text("service_offer_id")->nullable();            
            $table->string('communication_type')->nullable();
            $table->enum('type',['match me', 'search local'])->default("match me")->nullable();
            $table->date('date');
            $table->boolean("publication_status")->default(false);

            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("advisor_id")->references("id")->on("advisors")->cascadeOnDelete();
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
        Schema::dropIfExists('leads');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("subscription_plan_id");
            $table->unsignedBigInteger("service_offer_id")->nullable();
            $table->enum("rating_type",["specific", "non-specific"]);
            $table->integer("no_of_question")->default(1);
            $table->integer("no_of_star")->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign("subscription_plan_id")->references("id")->on("subscription_plans");
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
        Schema::dropIfExists('match_ratings');
    }
}

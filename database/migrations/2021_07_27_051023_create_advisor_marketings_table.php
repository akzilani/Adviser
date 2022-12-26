<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisorMarketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advisor_marketings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('primary_region_id')->nullable();
            $table->unsignedBigInteger('service_offer_id')->nullable();
            $table->string('image');

            $table->foreign("primary_region_id")->references("id")->on("primary_reasons");
            $table->foreign("service_offer_id")->references("id")->on("service_offers");
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
        Schema::dropIfExists('advisor_marketings');
    }
}

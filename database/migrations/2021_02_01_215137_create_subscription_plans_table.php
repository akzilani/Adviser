<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->double("profile_listing_star")->default(2);
            $table->boolean("index_search_list")->default(false);
            $table->boolean("auction_room_access")->default(0);
            $table->boolean("qualified_leads")->default(false);
            $table->boolean("per_lead_tbc")->default(false);
            $table->boolean("account_manager")->default(false);
            $table->double("max_qualified_leads_per_month")->default(0);
            $table->double("max_advisor")->default(0);
            $table->double("price")->default(0);
            $table->string("duration_type")->nullable();
            $table->string("charge_type")->nullable();
            $table->boolean('publication_status')->default(true);
            
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('subscription_plans');
    }
}

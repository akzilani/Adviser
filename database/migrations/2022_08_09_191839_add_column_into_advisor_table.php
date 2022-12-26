<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIntoAdvisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("advisors", function(Blueprint $table){
            $table->boolean("accept_auction_condition")->default(false)->after("non_specific_rating");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("advisors", function(Blueprint $table){
            $table->dropColumn("accept_auction_condition");
        });
    }
}

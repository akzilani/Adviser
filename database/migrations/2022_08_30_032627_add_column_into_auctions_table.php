<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIntoAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("auctions", function(Blueprint $table){
            $table->foreignId("profession_id")->nullable()->references("id")->on("professions")->after("service_offer_id");
            $table->text("duration")->nullable()->after("start_time");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("auctions", function(Blueprint $table){
            $table->dropColumn("profession_id");
            $table->dropColumn("duration");
        });
    }
}

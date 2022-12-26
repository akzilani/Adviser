<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuyoutColumnIntoAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("auctions", function(Blueprint $table){
            $table->double("buy_out_price")->default(0)->after('bid_increment');
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
            $table->removeColumn("buy_out_price");
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIntoFirmDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("firm_details", function(Blueprint $table){
            $table->string("firm_town")->nullable()->after("firm_fca_number");
            $table->string("firm_post_code")->nullable()->after("firm_town");
            $table->string("firm_country")->nullable()->after("firm_post_code");
            $table->string("firm_address_line_one")->nullable()->after("firm_country");
            $table->string("firm_address_line_two")->nullable()->after("firm_address_line_one");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("firm_details", function(Blueprint $table){
            $table->dropColumn("firm_town");
            $table->dropColumn("firm_post_code");
            $table->dropColumn("firm_country");
            $table->dropColumn("firm_address_line_one");
            $table->dropColumn("firm_address_line_two");
        });
    }
}

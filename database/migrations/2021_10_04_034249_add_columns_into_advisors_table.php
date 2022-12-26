<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsIntoAdvisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advisors', function (Blueprint $table) {
            $table->date('terms_and_condition_agree_date')->nullable()->after("status");
            $table->integer('no_of_subscription_accounts')->nullable()->after("terms_and_condition_agree_date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advisors', function (Blueprint $table) {
            $table->dropColumn('terms_and_condition_agree_date');
            $table->dropColumn('no_of_subscription_accounts');
        });
    }
}

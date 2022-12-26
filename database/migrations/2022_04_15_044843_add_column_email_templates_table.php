<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("email_templates", function(Blueprint $table){
            $table->boolean("third_party_email_send")->default(false)->after('send_to_cc');
            $table->string("third_party_email")->nullable()->after('third_party_email_send');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("email_templates", function(Blueprint $table){
            $table->dropColumn("third_party_email_send");
            $table->dropColumn("third_party_email");
        });
    }
}

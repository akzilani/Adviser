<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAdvisorBlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advisor_blogs', function (Blueprint $table) {
            $table->dropForeign("advisor_blogs_advisor_id_foreign");
            $table->dropColumn("advisor_id");
            $table->unsignedBigInteger("admin_id")->after("id")->nullable();
            $table->foreign("admin_id")->references("id")->on("admins");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advisor_blogs', function (Blueprint $table) {
            $table->unsignedBigInteger("advisor_id")->after("id")->nullable();
            $table->foreign("advisor_id")->references("id")->on("advisors");
            $table->dropForeign("advisor_blogs_admin_id_foreign");
            $table->dropColumn("admin_id");
        });
    }
}

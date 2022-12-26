<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string('service_interest');
            $table->string("first_name");
            $table->string("last_name")->nullable();
            $table->string("company_name")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("email")->nullable();
            $table->string("post_code")->nullable();
            $table->boolean("store_data")->default(false);
            $table->boolean("call_permission")->default(false);
            $table->boolean("email_permission")->default(false);
            $table->boolean("text_permission")->default(false);
            $table->boolean("is_seen")->default(false);
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
        Schema::dropIfExists('contact_us');
    }
}

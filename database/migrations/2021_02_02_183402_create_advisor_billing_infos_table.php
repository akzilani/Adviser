<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisorBillingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advisor_billing_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("advisor_id");
            $table->string("contact_name");
            $table->string("billing_address_line_one")->nullable();
            $table->string("billing_address_line_two")->nullable();
            $table->string("billing_town")->nullable();
            $table->string("billing_post_code")->nullable();
            $table->string("billing_country")->nullable();
            $table->string("billing_company_name")->nullable();            
            $table->string("billing_company_fca_number")->nullable();
            
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("advisor_id")->references("id")->on("advisors")->cascadeOnDelete();
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
        Schema::dropIfExists('advisor_billing_infos');
    }
}

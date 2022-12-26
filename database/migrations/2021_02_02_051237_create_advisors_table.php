<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advisors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('primary_region_id')->nullable();           
            $table->text('subscribe_primary_region_id')->nullable();
            $table->unsignedBigInteger('firm_size_id')->nullable();           
            $table->unsignedBigInteger('profession_id')->nullable();
            $table->unsignedBigInteger('subscription_plan_id')->nullable();
            $table->unsignedBigInteger('fund_size_id')->nullable();
            $table->text('location_postcode_id')->nullable();
            $table->text('subscribe_location_postcode_id')->nullable();
            $table->text('advisor_type_id')->nullable();
            $table->text('service_offered_id')->nullable();


            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('telephone')->nullable();
            $table->boolean('view_telephone_no')->default(0);
            $table->string('email')->unique();
            $table->string('personal_fca_number')->nullable();
            $table->date('fca_status_date')->nullable();            
            $table->string('address_line_one')->nullable();
            $table->string('address_line_two')->nullable();
            $table->string('town')->nullable();
            $table->string('post_code')->nullable();
            $table->string('country')->nullable();            
            $table->enum('status', ['active', 'inactive'])->default("active");
            $table->boolean("is_live")->default(true);
            $table->boolean('subscribe')->default(false);
            $table->double('non_specific_rating')->default(0);
            $table->text('specific_rating')->default(0);
            
            $table->string("latitude")->nullable();
            $table->string("longitude")->nullable();
            $table->text("profile_brief")->nullable();
            $table->string("image")->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();


            $table->foreign("created_by")->references("id")->on("admins");
            $table->foreign("updated_by")->references("id")->on("admins");
            $table->foreign("primary_region_id")->references("id")->on("primary_reasons");
            $table->foreign("firm_size_id")->references("id")->on("firm_sizes");
            $table->foreign("profession_id")->references("id")->on("professions");
            $table->foreign("subscription_plan_id")->references("id")->on("subscription_plans");
            $table->foreign("fund_size_id")->references("id")->on("fund_sizes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advisors');
    }
}

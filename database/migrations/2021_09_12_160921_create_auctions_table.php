<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('fund_size_id');
            $table->text('primary_region_id');
            $table->text("service_offer_id")->nullable(); 
                      
            $table->text('question'); 
            $table->string('post_code')->nullable(); 
            $table->string('communication_type')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->double('base_price')->default(0);
            $table->double('min_bid_price')->default(0);
            $table->double('bid_increment')->default(1);
            $table->enum('type',['match me', 'search local'])->default("match me")->nullable();
            $table->enum('status',['not_started','running','completed', "cancelled"]);
            $table->unsignedBigInteger('max_bidder_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();


            $table->foreign("created_by")->references("id")->on("admins");
            $table->foreign("updated_by")->references("id")->on("admins");
            $table->foreign('fund_size_id')->references('id')->on('fund_sizes')->cascadeOnDelete();
            $table->foreign('max_bidder_id')->references('id')->on('advisors')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
}

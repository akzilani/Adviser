<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlanOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plan_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscription_plan_id');
            $table->string('key');
            $table->enum('status', ['active', 'inactive']);
            $table->string('text');
            $table->integer('position')->default(1);
            $table->boolean('delete_able')->default(true);
            $table->timestamps();

            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plan_options');
    }
}

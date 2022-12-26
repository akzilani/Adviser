<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firm_sizes', function (Blueprint $table) {
            $table->id();
            $table->double("min_range")->default(0);
            $table->double("max_range")->default(0);
            $table->double("amount")->default(0);
            $table->boolean("publication_status")->default(false);
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('firm_sizes');
    }
}

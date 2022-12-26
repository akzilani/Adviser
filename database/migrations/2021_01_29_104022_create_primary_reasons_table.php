<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrimaryReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_reasons', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->integer('position')->default(1);
            $table->boolean("publication_status");
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
        Schema::dropIfExists('primary_reasons');
    }
}

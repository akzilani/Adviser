<?php

use App\LocationPostCodes;
use App\SubscribePostCodes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribePostCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_post_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("primary_region_id");
            $table->string("short_name");
            $table->string("full_name");
            $table->boolean("publication_status");

            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("created_by")->references("id")->on("admins");
            $table->foreign("updated_by")->references("id")->on("admins");
            $table->foreign("primary_region_id")->references("id")->on("subscribe_primary_reasons");
        });

        $this->migrateData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_post_codes');
    }

    protected function migrateData(){
        $post_codes = LocationPostCodes::all();
        foreach($post_codes as $post_code){
            $data = new SubscribePostCodes();
            $data->id = $post_code->id;
            $data->primary_region_id = $post_code->primary_region_id;
            $data->short_name = $post_code->short_name;
            $data->full_name = $post_code->full_name;
            $data->publication_status = $post_code->publication_status;
            $data->save();
        }
    }
}

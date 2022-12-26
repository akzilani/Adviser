<?php

use App\PrimaryReason;
use App\SubscribePrimaryReason;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribePrimaryReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_primary_reasons', function (Blueprint $table) {
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

        $this->migrateData();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_primary_reasons');
    }

    /**
     * Load And Migrate All Reasons from Primary Reason
     */
    protected function migrateData(){
        $primary_reasons = PrimaryReason::all();
        foreach($primary_reasons as $data_row){
            $data = new SubscribePrimaryReason();
            $data->id = $data_row->id;
            $data->name = $data_row->name;
            $data->position = $data_row->position;
            $data->publication_status = $data_row->publication_status;
            $data->save();
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
            DB::statement("ALTER TABLE `blogs` CHANGE `advisor_id` `admin_id` BIGINT(20) NOT NULL; ");
        }catch(Exception $e){
            
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try{
            DB::statement("ALTER TABLE `blogs` CHANGE `admin_id` `advisor_id` BIGINT(20) NOT NULL;");
        }catch(Exception $e){
            
        }
    }
}

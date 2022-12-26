<?php

use App\Http\Controllers\Import\CommunicationController;
use Illuminate\Database\Seeder;

class CommunicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommunicationController::import();
    }
}

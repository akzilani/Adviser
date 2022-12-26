<?php

use App\Import\LeadImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class leadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Leads Import
        $file_path = base_path('database/imports/leads.csv');
        Excel::import(new LeadImport, $file_path);
    }
}

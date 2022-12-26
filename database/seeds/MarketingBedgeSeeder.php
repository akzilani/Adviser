<?php

use App\Import\AdvisorMarketingImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MarketingBedgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Advisor Marketing Import
        $file_path = base_path('database/imports/advisor_marketings.csv');
        Excel::import(new AdvisorMarketingImport, $file_path);
    }
}

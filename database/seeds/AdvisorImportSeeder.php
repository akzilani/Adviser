<?php

use App\Import\AdvisorBillingImport;
use App\Import\AdvisorImageImport;
use App\Import\AdvisorImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class AdvisorImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Advisor List Import
        $file_path = base_path('database/imports/advisors.csv');
        Excel::import(new AdvisorImport, $file_path);

        // Billing Info Import
        $file_path = base_path('database/imports/advisor_billings.csv');
        Excel::import(new AdvisorBillingImport, $file_path);

        // Advisor Images Import
        $file_path = base_path('database/imports/advisor_profiles.csv');
        Excel::import(new AdvisorImageImport, $file_path);
    }
}

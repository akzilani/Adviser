<?php

use App\Import\AdvisorComplanceImport;
use App\Import\AdvisorInterviewImport;
use App\Import\AdvisorQuestionsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class AdvisorQuestionsImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Advisor Interview Import
        $file_path = base_path('database/imports/advisor_interview_questions.csv');
        Excel::import(new AdvisorInterviewImport, $file_path);

        // Advisor Question Import
        $file_path = base_path('database/imports/advisors_questions.csv');
        Excel::import(new AdvisorQuestionsImport, $file_path);

        // Advisor Complance
        $file_path = base_path('database/imports/complance.csv');
        Excel::import(new AdvisorComplanceImport, $file_path);
    }
}

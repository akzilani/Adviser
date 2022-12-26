<?php

use App\Import\AdvisorTestimonialImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class TestimonialImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Advisor Testimonial Import
        $file_path = base_path('database/imports/testimonials.csv');
        Excel::import(new AdvisorTestimonialImport, $file_path);
    }
}

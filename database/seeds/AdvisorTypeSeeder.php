<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdvisorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `advisor_types` (`id`, `name`, `publication_status`, `created_at`) VALUES
            (1, 'Independent Financial Advisor', 1, '2021-01-18 00:00:00'),
            (2, 'Restricted Financial Advisor', 1, '2021-01-18 00:00:00'),
            (3, 'Restricted Whole of Market Financial Advisor', 1, '2021-01-18 00:00:00'),
            (4, 'Whole of Market Mortgage Advisor', 1, '2021-01-18 00:00:00');
        ");
    }
}

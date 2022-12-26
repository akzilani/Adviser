<?php

use App\PrimaryReason;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrimaryReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `primary_reasons` (`id`, `name`, `publication_status`,`created_at`) VALUES
            (3, 'Scotland', 1, '2021-01-18 21:05:45'),
            (4, 'Wales', 1, '2021-01-18 21:05:45'),
            (5, 'North East', 1, '2021-01-18 21:17:39'),
            (6, 'North West', 1, '2021-01-18 21:17:39'),
            (7, 'Yorkshire & Humberside', 1, '2021-01-18 21:17:39'),
            (8, 'West Midlands', 1, '2021-01-18 21:05:45'),
            (9, 'East Midlands', 1, '2021-01-18 21:05:45'),
            (10, 'East of England', 1, '2021-01-18 21:05:45'),
            (11, 'South East', 1, '2021-01-18 21:05:45'),
            (12, 'Greater London', 1, '2021-01-18 21:05:45'),
            (14, 'South West', 1, '2021-01-18 21:05:45'),
            (15, 'Other Regions', 1, '2021-01-18 21:05:45');
        ");
    }
}

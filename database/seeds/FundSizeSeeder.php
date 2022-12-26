<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `fund_sizes` (`id`, `name`, `min_fund`,`publication_status`, `created_at`) VALUES
            (1, 'Any fund size', '-1', 1, '2021-01-18 21:05:45'),
            (2, 'More than £50,000', '50000', 1, '2021-01-18 21:05:45'),
            (3, 'More than £100,000', '100000', 1, '2021-01-18 21:17:39'),
            (4, 'More than £250,000', '250000', 1, '2021-01-18 21:17:39'),
            (5, 'More than £500,000', '500000', 1, '2021-01-18 21:17:39');
        ");
    }
}

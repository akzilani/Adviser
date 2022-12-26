<?php

use App\FirmSize;
use Illuminate\Database\Seeder;

class FirmSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FirmSize::create([
            "min_range"  => "1",
            "max_range"  => "5",
            "amount"        => "500",
            "publication_status"    => true,
        ]);
        
        FirmSize::create([
            "min_range"  => "6",
            "max_range"  => "10",
            "amount"     => "600",
            "publication_status"    => true,
        ]);
    }
}

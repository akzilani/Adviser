<?php

use App\Profession;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profession::create([
            "name"  => "Financial Advisor",
            "publication_status"    => true,
        ]);

        Profession::create([
            "name"  => "Mortgage Advisor",
            "publication_status"    => true,
        ]);
    }
}

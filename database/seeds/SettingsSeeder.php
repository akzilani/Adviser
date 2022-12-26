<?php

use App\System;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        System::create([
            "application_name"      => "Regulated Advice",
            "title_name"            => "Regulated Advice",
            "email"                 => "regulated@gmail.com",
            "phone"                 => Null,
            "city"                  => Null,
            "postal_code"           => Null,
            "address"               => Null,
            "country"               => "UK",
            "state"                 => Null,
            "app_version"           => "1.0",
            "date_format"           => "Y-m-d",
            "currency"              => "GBP",
            "currency_symbol"       => "£",
            "time_zone"             => "UTC",
        ]);
    }
}

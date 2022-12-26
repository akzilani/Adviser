<?php

use App\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            "name"              => "Shahjalal Shaju",
            "email"             => "shajushahjalal@gmail.com",
            "phone"             => "+8801760383184",
            "group_id"          => 1,
            "email_verified_at" => Carbon::now(),
            'is_developer'      => true,
            "password"          => bcrypt("shajushahjalal@gmail.com"),
        ]);

        Admin::create([
            "name"              => "Regulated Advice",
            "email"             => "regulated@gmail.com",
            "group_id"          => 1,
            "email_verified_at" => Carbon::now(),
            "password"          => bcrypt("ben25"),
        ]);

        Admin::create([
            "name"              => "Admin",
            "email"             => "admin@admin.com",
            "group_id"          => 1,
            "email_verified_at" => Carbon::now(),
            "password"          => bcrypt("admin@admin.com"),
        ]);
    }
}

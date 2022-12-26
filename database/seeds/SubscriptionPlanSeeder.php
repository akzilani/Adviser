<?php

use App\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubscriptionPlan::create([
            "id"                    => 1,
            "name"                  => "Basic",
            "profile_listing_star"  => 2,
            "index_search_list"     => true,
            "auction_room_access"   => true,
            "qualified_leads"       => false,
            "per_lead_tbc"          => false,
            "account_manager"       => false,
            "max_qualified_leads_per_month" => 0,
            "max_advisor"           => 0,
            "price"                 => 0,
        ]);

        SubscriptionPlan::create([
            "id"                    => 2,
            "name"                  => "Professional",
            "profile_listing_star"  => 5,
            "index_search_list"     => true,
            "auction_room_access"   => true,
            "qualified_leads"       => true,
            "per_lead_tbc"          => true,
            "account_manager"       => true,
            "max_qualified_leads_per_month" => 5,
            "max_advisor"           => 0,
            "price"                 => 480,
            "duration_type"         => "per year",
            "charge_type"           => "per Profile"
        ]);

        SubscriptionPlan::create([
            "id"                    => 3,
            "name"                  => "Premium",
            "profile_listing_star"  => 5,
            "index_search_list"     => true,
            "auction_room_access"   => true,
            "qualified_leads"       => true,
            "per_lead_tbc"          => true,
            "account_manager"       => true,
            "max_qualified_leads_per_month" => 30,
            "max_advisor"           => 3,
            "price"                 => 480,
            "duration_type"         => "per years",
            "charge_type"           => "per Account"
        ]);
    }
}

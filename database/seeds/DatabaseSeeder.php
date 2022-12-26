<?php

use App\Import\AdvisorTestimonialImport;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingsSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(FirmSizeSeeder::class);
        $this->call(PrimaryReasonSeeder::class);
        $this->call(LocationPostCodeSeeder::class);
        $this->call(ServiceOfferSeeder::class);

        $this->call(AdvisorTypeSeeder::class);
        $this->call(FundSizeSeeder::class);
        $this->call(SubscriptionPlanSeeder::class);
        $this->call(ProfessionSeeder::class);
        $this->call(AdvisorImportSeeder::class);
        $this->call(AdvisorQuestionsImportSeeder::class);
        $this->call(TestimonialImportSeeder::class);
        $this->call(leadSeeder::class);
        $this->call(CommunicationSeeder::class);
        $this->call(TermsAndConditionSeeder::class);
        $this->call(MarketingBedgeSeeder::class);

    }
}

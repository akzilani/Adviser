<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `service_offers` (`id`, `name`, `description`, `publication_status`, `image`,`created_at`) VALUES
            (1, 'Investment & Savings', 'Investing your money provides a greater opportunity to increase your money than a traditional savings account.', 1, 'image/pig.png','2021-01-18 00:00:00'),
            (2, 'Pensions', '', 1, 'image/pensions.png','2021-01-18 00:00:00'),
            (3, 'Pension Review', 'The service we provide is free initially, we\'\ll show you how your pension is performing free of charge.', 1, 'image/piechart.png','2021-01-18 00:00:00'),
            (4, 'Final Salary Pension Schemes', 'Our Financial Advisors can help you decide your best options should you have a defined benefit scheme.', 1, 'image/calendar.png', '2021-01-18 00:00:00'),
            (5, 'Retirement Income Planning', '', 1, 'image/retirement_income_planning.png', '2021-01-18 00:00:00'),
            (6, 'Pension Income Drawdown', '', 1, 'image/pension_income_drawdown.png', '2021-01-18 00:00:00'),
            (7, 'Annuity Purchase', '', 1, 'image/annuity_purchase.png', '2021-01-18 00:00:00'),
            (8, 'Inheritance Tax Planning', 'A Financial Advisor can help you to avoid passing on a large inheritance tax bill when you come to pass on your assets.', 1, 'image/calculator.png', '2021-01-18 00:00:00'),
            (9, 'Insurance & Protection', 'There is a wide variety of insurance products available to protect you and your family from all kinds of unexpected events.', 1, 'image/moneyparachute2.png', '2021-01-18 00:00:00'),
            (10, 'Mortgage Advice', 'Getting the right financial advice can prove crucial whether you are buying your first home or releasing equity later in life.', 1, 'image/house.png', '2021-01-18 00:00:00'),
            (11, 'Equity Release (min age 55)', 'Getting the right financial advice can prove crucial whether you are buying your first home or releasing equity later in life.', 1, 'image/equity_release.png', '2021-01-18 00:00:00'),
            (12, 'Financial Advice for Business', '', 1, 'image/financial_advice_for_business.png', '2021-01-18 00:00:00'),
            (13, 'General Financial Advice', '', 1, 'image/general_financial_advice.png', '2021-01-18 00:00:00');
        ");
    }
}

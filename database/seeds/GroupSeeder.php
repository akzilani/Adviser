<?php

use App\Group;
use App\GroupAccess;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            "name"          => "Super Admin",
            "description"   => "All Permission For Super Admin",
            "is_admin"      => 1
        ]);

        GroupAccess::create([
            "group_id"      => 1,
            "group_access"  => ["admin_list","admin_create","admin_delete","admin_restore","setting","advisor_list","advisor_create","advisor_update","advisor_delete","advisor_billing","advisor_update","promotional_list","promotional_create","promotional_delete","advisor_restore","lead_list","lead_create","lead_update","lead_delete","advisorQuestion_list","advisorQuestion_create","advisorQuestion_update","advisorQuestion_delete","interview_question_list","interview_question_create","interview_question_update","interview_question_delete","interview_question_answer_list","advisorType_list","advisorType_create","advisorType_update","advisorType_delete","profession_list","profession_create","profession_update","profession_delete","profession_list","profession_create","profession_update","profession_delete","firmSize_list","firmSize_create","firmSize_update","firmSize_delete","fundSize_list","fundSize_create","fundSize_update","fundSize_delete","serviceOffer_list","serviceOffer_create","serviceOffer_update","serviceOffer_delete","primaryReason_list","primaryReason_create","primaryReason_update","primaryReason_delete","postcode_list","postcode_create","postcode_update","postcode_delete","subscription_list","subscription_create","subscription_update","subscription_delete","testimonial_list","testimonial_create","testimonial_update","testimonial_delete","communication_list","communication_create","communication_update","communication_delete","quick_link","quick_link_create","quick_link_update","quick_link_delete","blog","blog_create","blog_update","blog_delete","terms_&_condition","enquires","group_list","group_create","group_update","group_delete"]
        ]);
    }
}

<?php

namespace App\Import;

use App\AdvisorBillingInfo;
use App\AdvisorType;
use App\FirmDetails;
use App\FirmSize;
use App\FundSize;
use App\PrimaryReason;
use App\Profession;
use App\ServiceOffer;
use App\SubscriptionPlan;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AdvisorListImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        try{
            DB::beginTransaction();
            foreach ($rows as $row) 
            { 
                try{
                    $profession = $this->getProfessionInfo($row['0']);
                    $subscription_plan = $this->getSubscriptionPlan($row[11]);
                    $fund_size = $this->getFundByName($row['12']);
                    $promary_reason = $this->getPrimaryReasonByName($row['13']);
                    $advisor = User::where("email", $row[3])->withTrashed()->first();
                    if( !empty($advisor) ){
                        continue;
                    }
                    $advisor = new User();
                    $advisor->profession_id     = $profession ->id;
                    $advisor->first_name        = $row[1];
                    $advisor->last_name         = $row[2];
                    $advisor->email             = $row[3];
                    $advisor->password          = bcrypt($row[4]);
                    $advisor->phone             = '0'.$row[5];
                    $advisor->address_line_one  = $row[6];
                    $advisor->address_line_two  = $row[7] != "NULL" ? $row[7] : null;
                    $advisor->town              = $row[8] != "NULL" ? $row[8] : null;
                    $advisor->country           = $row[9] != "NULL" ? $row[9] : null;
                    $advisor->post_code         = $row[10];
                    $advisor->subscription_plan_id = $subscription_plan->id ?? null;
                    $advisor->fund_size_id          = $fund_size->id ?? null;
                    $advisor->primary_region_id     = $promary_reason->id ?? null;

                    $advisor->subscribe         = $row[14] == "No" ? false : true;
                    $advisor->status            = $row[15] == "Pause" ? "inactive" : "active";
                    $advisor->service_offered_id = $this->prepareServiceOffer($row);                    
                    $advisor->created_at        = now();
                    $advisor->save();

                    $this->setFirmDetailsInfo($advisor, $row);
                    $this->setBillingInfo($advisor, $row);
                }catch(Exception $e){
                    throw new Exception($e->getMessage().". Error In Import Excel File on Email: ".$row[3], 500);
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            throw new Exception($e->getMessage(), 500);
        }
        
    }

    /**
     * Get Subscriotion Plan
     */
    protected function getSubscriptionPlan($plan_name){
        $subscription_plan = SubscriptionPlan::where("name", $plan_name)->orderBy("id", "DESC")->first();
        if( !empty($subscription_plan) ){
            return $subscription_plan;
        }
        return null;
    }

    /**
     * Area Of Advice
     */
    protected function getAreaOfAdvice($area_name){
        return ServiceOffer::where("name", $area_name)->orderBy("id", "DESC")->first();
    }

    /**
     * Set Firm Info
     */
    protected function setFirmDetailsInfo($advisor, $row){
        $firm = new FirmDetails();
        $firm->advisor_id = $advisor->id;
        $firm->profile_name = $advisor->first_name . ' ' . $advisor->last_name;;
        $firm->profile_details = "TBC";
        $firm->firm_fca_number = "TBC";
        $firm->firm_website_address = "TBC";
        $firm->linkedin_id = "TBC";
        $firm->save();
    }

    /**
     * Set Billing Info
     */
    protected function setBillingInfo($advisor, $row){
        $firm = AdvisorBillingInfo::where("advisor_id", $advisor->id)->first();
        if( empty($firm) ){
            $firm = new AdvisorBillingInfo();
        }
        
        $firm->advisor_id = $advisor->id;
        $firm->contact_name = $row[19];
        $firm->billing_address_line_one = $row[18];
        $firm->billing_address_line_two = "";
        $firm->billing_town = "TBC";
        $firm->billing_post_code = $row[22];
        $firm->billing_country = $row[21];
        $firm->billing_company_name = $row[20];
        $firm->billing_company_fca_number = "TBC";
        $firm->billing_company_fca_number = "TBC";
        $firm->save();
    }

    /**
     * Get Or Set Advisor Profession
     */
    protected function getProfessionInfo($name){
        $profession = Profession::where('name', $name)->first();
        if( empty($profession) ){
            $profession = new Profession();
            $profession->name = $name;
            $profession->publication_status = 1;
            $profession->save();
        }
        return $profession;
    }


    protected function getFundByName($name){
        $fund = FundSize::where('name', $name)->first();
        return $fund;
    }

    /**
     * Get Promary Reason By Name
     */
    protected function getPrimaryReasonByName($name){
        return PrimaryReason::where("name", $name)->orderBy("id", "DESC")->first();
    }

    /**
     * Prepare Array From string
     */
    protected function prepareLocationPostCode($string = ""){
        if($string == NULL || $string == "NULL"){
            return "";
        }
        return explode(',',$string);
    }

    /**
     * Prepare Advisor Type Array
     */
    protected function prepareAdvisorType($row){
        $type = [];
        $_type = AdvisorType::where("name", $row[17])->first();
        if( !empty($_type) ){
            $type[] = $_type->id;
        }
        return $type;
    }

    /**
     * Prepare Service offer
     */
    protected function prepareServiceOffer($row){
        $service_offer = $this->getAreaOfAdvice($row['16']);
        if( !empty($service_offer) ){
            return [$service_offer->id];
        }
        return [];
    }
} 
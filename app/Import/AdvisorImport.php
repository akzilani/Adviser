<?php

namespace App\Import;

use App\FirmDetails;
use App\FirmSize;
use App\FundSize;
use App\Profession;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AdvisorImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 1;
    }

    public function collection(Collection $rows)
    {
        try{
            DB::beginTransaction();
            foreach ($rows as $row) 
            { 
                try{
                    $profession = $this->getProfessionInfo($row['13']);
                    $fund_size = $this->getFundSize($row['43']);

                    $advisor = new User();
                    $advisor->id                = $row[0];
                    $advisor->primary_region_id = $row[2];
                    // $advisor->firm_size_id = "";
                    $advisor->profession_id     = $profession ->id;
                    $advisor->subscription_plan_id = $row[18];
                    $advisor->fund_size_id      = $fund_size->id;
                    $advisor->location_postcode_id = $this->prepareLocationPostCode($row[3]);
                    $advisor->advisor_type_id = $this->prepareAdvisorType($row);
                    $advisor->service_offered_id = $this->prepareServiceOffer($row);
                    $advisor->first_name        = $row[4];
                    $advisor->last_name         = $row[5];
                    $advisor->phone             = '0'.$row[9];
                    $advisor->telephone         = $row[10] != "NULL" ? $row[10] : null;
                    $advisor->email             = $row[6];
                    $advisor->personal_fca_number= $row[11];
                    $advisor->fca_status_date   = empty($row[12]) || $row[12] == "NULL" || $row[12] == Null ? Null : Carbon::parse($row[12])->format('Y-m-d');
                    $advisor->address_line_one  = $row[19];
                    $advisor->address_line_two  = $row[20] != "NULL" ? $row[20] : null;
                    $advisor->town              = $row[21] != "NULL" ? $row[21] : null;
                    $advisor->post_code         = $row[22];
                    $advisor->country           = $row[23] != "NULL" ? $row[23] : null;
                    
                    $status = json_decode($row[49]);
                    $advisor->status            = isset($status->live) && $status->live == 1 ? 'active' : 'inactive';
                    $advisor->subscribe         = $status->paid ?? false;
                    $advisor->latitude          = $row[56] != "NULL" ? $row[56] : null;
                    $advisor->longitude         = $row[57] != "NULL" ? $row[57] : null;
                    // $advisor->image             = $row[4];
                    $advisor->password          = bcrypt($row[6]);
                    $advisor->email_verified_at = empty($row[52]) || $row[52] == "NULL" ||  $row[52] == Null ? Null : Carbon::parse($row[52])->format('Y-m-d');
                    $advisor->created_at        = Carbon::parse($row[61])->format('Y-m-d H:i:s');
                    $advisor->save();
                    $this->setFirmDetailsInfo($advisor->id, $row);
                }catch(Exception $e){
                    dd($e->getMessage() .' error on ID '.  $row[0]);
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            dd($e->getMessage().' on Line '.$e->getLine());
        }
        
    }

    /**
     * Set Firm Info
     */
    protected function setFirmDetailsInfo($advisor_id, $row){
        $firm = new FirmDetails();
        $firm->advisor_id = $advisor_id;
        $firm->profile_name = $row[25];
        $firm->profile_details = $row[50];
        $firm->firm_fca_number = $row[26];
        $firm->firm_website_address = $row[27];
        $firm->linkedin_id = $row[28];
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

    /**
     * Fund Size Info
     */
    protected function getFundSize($amount){
        if($amount == 1 || $amount == "NULL" || empty($amount)){
            return FundSize::where('min_fund', -1)->first();
        }
        $fund = FundSize::where('min_fund', $amount)->first();
        if( empty($fund) ){
            $fund = new FundSize();
            $fund->name     = 'More than £'. number_format($amount);
            $fund->min_fund = $amount;
            $fund->publication_status = 1;
            $fund->save();
        }
        return $fund;
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
        if( $row[14] == 1 ){
            array_push($type, 1);
        }
        if( $row[15] == 2 ){
            array_push($type, 2);
        }
        if( $row[16] == 3 ){
            array_push($type, 3);
        }
        if( $row[17] == 4 ){
            array_push($type, 4);
        }
        return $type;
    }

    /**
     * Prepare Service offer
     */
    protected function prepareServiceOffer($row){
        $service_offer = [];
        if( $row[30] == 1 ){            
            array_push($service_offer, 1); //investment_saving
        }
        if( $row[31] == 1 ){            
            array_push($service_offer, 2); // pension
        }
        if( $row[32] == 1 ){
            array_push($service_offer, 3); //pension_review
        }
        if( $row[33] == 1 ){
            array_push($service_offer, 4); //final_salary_pension_schema
        }
        if( $row[34] == 1 ){
            array_push($service_offer, 5); //retirement_income_planning
        }
        if( $row[35] == 1 ){
            array_push($service_offer, 6); //pension_income_drawdown
        }
        if( $row[36] == 1 ){
            array_push($service_offer, 7); //annuity_purches
        }
        if( $row[37] == 1 ){
            array_push($service_offer, 13); //general_financial_advice
        }
        if( $row[38] == 1 ){
            array_push($service_offer, 8); //inheritance_tax_planning
        }
        if( $row[39] == 1 ){
            array_push($service_offer, 9); // insurance_protection
        }
        if( $row[40] == 1 ){
            array_push($service_offer, 10); // mortgage_advice (40)
        }
        if( $row[41] == 1 ){
            array_push($service_offer, 11); //equity_release
        }
        if( $row[42] == 1 ){
            array_push($service_offer, 12); // financial_advice_business
        }
        return $service_offer;
    }
} 
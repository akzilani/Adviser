<?php

namespace App\Import;

use App\Leads;
use App\ServiceOffer;
use App\User;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LeadImport implements ToCollection, WithStartRow{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows){
        try{
            DB::beginTransaction();
            foreach($rows as $row){
                try{
                    $advisor = User::find($row[1]);
                    $lead = new Leads();
                    $lead->id = $row[0];
                    $lead->advisor_id   = $advisor->id ?? Null;
                    $lead->fund_size_id = $this->getFundSizeId($row[5]);
                    $lead->name = $row[7];
                    $lead->email = $row[8];
                    $lead->phone = $row[9];
                    $lead->post_code = $row[3];
                    $lead->question     = $row[2];
                    $lead->service_offer_id = $this->getServiceOfferIdArr($row[4]);
                    $lead->communication_type = $row[6];
                    $lead->type = $row[10] == "Search Locally" ? 'search local' : 'match me';
                    $lead->date = Carbon::parse($row[13])->format('Y-m-d');
                    $lead->publication_status = 1;
                    $lead->save();
                    
                }catch(Exception $e){
                    throw new Exception("Error on Add Lead => Row ID: ".$row[0]. "." .$e->getMessage());
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    protected function getFundSizeId($name = null){
        if( empty($name) ){
            return "";
        }elseif($name == "More than Â£50,000"){
            return 2;
        }elseif($name == "More than Â£100,000"){
            return 3;
        }elseif($name == "More than Â£250,000"){
            return 4;
        }elseif($name == "More than Â£500,000"){
            return 5;
        }else{
            return 1;
        }
    }

    protected function getServiceOfferIdArr($name = null){
        if( empty($name) ){
            return [];
        }
        return ServiceOffer::where('name', $name)->get()->pluck('id')->toArray();
    }
}
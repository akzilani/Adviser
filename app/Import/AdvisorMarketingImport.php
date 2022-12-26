<?php

namespace App\Import;

use App\AdvisorMarketing;
use App\ServiceOffer;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdvisorMarketingImport implements ToCollection, WithStartRow{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows){
        try{
            DB::beginTransaction();
            foreach($rows as $row){
                try{
                    $service_offer = $this->getServiceOffer($row[2]);
                    if( !empty($service_offer) ){
                        $markiting = new AdvisorMarketing();
                        $markiting->id               = $row[0];
                        $markiting->primary_region_id= $row[1];
                        $markiting->service_offer_id = $service_offer->id;
                        $markiting->image            = 'marketing/'.$row[3];
                        $markiting->created_at       = Carbon::parse($row[4])->format('Y-m-d H:i:s');
                        $markiting->updated_at       = Carbon::parse($row[5])->format('Y-m-d H:i:s');
                        $markiting->save();
                    }
                }catch(Exception $e){
                    throw new Exception("Error on Add Marketing ID: ".$row[0]);
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    /**
     * Get Service Offer
     */
    protected function getServiceOffer($service_offer_name){
        return ServiceOffer::where('name', $service_offer_name)->orWhere('name', $service_offer_name.'s')->first();
    }
}
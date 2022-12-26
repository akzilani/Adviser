<?php

namespace App\Import;

use App\AdvisorQuestion;
use App\ServiceOffer;
use App\User;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdvisorQuestionsImport implements ToCollection, WithStartRow{
    public function startRow(): int
    {
        return 1;
    }

    public function collection(Collection $rows){
        try{
            DB::beginTransaction();
            foreach($rows as $row){
                try{
                    $service_offer = $this->getServiceOffer($row[4]);
                    if( !empty($service_offer) ){
                        $question = new AdvisorQuestion();
                        $question->id               = $row[0];
                        $question->advisor_id       = $row[1];
                        $question->service_offer_id = $service_offer->id;
                        $question->question         = $row[2];
                        $question->answer           = $row[3];
                        $question->publication_status= 1;
                        $question->created_at           = $row[6];
                        $question->updated_at           = $row[7];
                        $question->save();
                    }
                }catch(Exception $e){
                    throw new Exception("Error on Add Questions Advisor ID: ".$row[1]);
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
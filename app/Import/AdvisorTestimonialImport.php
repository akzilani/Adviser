<?php

namespace App\Import;

use App\AdvisorQuestion;
use App\ServiceOffer;
use App\Testimonial;
use App\User;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdvisorTestimonialImport implements ToCollection, WithStartRow{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows){
        try{
            DB::beginTransaction();
            foreach($rows as $row){
                try{
                    $advisor = User::find($row[6]);
                    if( !empty($advisor) ){
                        $testimonial = new Testimonial();
                        $testimonial->advisor_id    = $advisor->id;
                        $testimonial->name          = $row[1];
                        $testimonial->location      = $row[2];
                        $testimonial->description   = $row[4];
                        $testimonial->publication_status = 1;
                        $testimonial->created_at    	= Carbon::parse($row[7])->format('Y-m-d H:i:s');
                        $testimonial->save();
                    }
                }catch(Exception $e){
                    throw new Exception("Error on Add Questions Advisor ID: ".$row[6]. "." .$e->getMessage());
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
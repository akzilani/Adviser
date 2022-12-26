<?php

namespace App\Import;

use App\AdvisorCompliance;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdvisorComplanceImport implements ToCollection, WithStartRow{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows){
        try{
            DB::beginTransaction();
            foreach($rows as $row){
                try{
                    for($i = 2; $i <= 7; $i++ ){
                        if( $row[$i] == "NULL" || $row[$i] == null){
                            continue;
                        }
                        $complance = new AdvisorCompliance();
                        $complance->advisor_id = $row[1];
                        $complance->compliance = $row[$i];
                        $complance->save();
                    }                    
                }catch(Exception $e){
                    throw new Exception("Error on Image Upload Row SN ID: ".$row[0]);
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
<?php

namespace App\Import;

use App\User;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdvisorImageImport implements ToCollection, WithStartRow{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows){
        try{
            DB::beginTransaction();
            foreach($rows as $row){
                try{
                    $profile = User::find($row[1]);
                    if( !empty($profile) ){
                        $profile->image = 'storage/uploads/advisor/'.$row[2];
                        $profile->profile_brief = $row[3];
                        $profile->save();
                    }
                }catch(Exception $e){
                    throw new Exception("Error on Image Upload Advisor ID: ".$row[1]);
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
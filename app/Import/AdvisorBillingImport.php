<?php

namespace App\Import;

use App\AdvisorBillingInfo;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdvisorBillingImport implements ToCollection, WithStartRow{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows){
        try{
            DB::beginTransaction();
            foreach($rows as $row){

                try{
                    $billing = new AdvisorBillingInfo();
                    $billing->id                    = $row[0];
                    $billing->advisor_id            = $row[1];
                    $billing->contact_name          = $row[2] != "NULL" ? $row[2] : '';
                    $billing->billing_company_name  = $row[3] != "NULL" ? $row[3] : null;
                    $billing->billing_company_fca_number = $row[4] != "NULL" ? $row[4] : null;
                    $billing->billing_address_line_one = $row[5] != "NULL" ? $row[5] : null;
                    $billing->billing_address_line_two = $row[6] != "NULL" ? $row[6] : null;
                    $billing->billing_town          = $row[7] != "NULL" ? $row[7] : null;
                    $billing->billing_country       = $row[8] != "NULL" ? $row[8] : null;
                    $billing->billing_post_code     = $row[9] != "NULL" ? $row[9] : null;
                    $billing->save();
                }catch(Exception $e){
                    throw new Exception("Error on Billing Import Advisor ID: ".$row[1].'. '. $e->getMessage());
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
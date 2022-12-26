<?php

namespace App\Import;

use App\Interview;
use App\User;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdvisorInterviewImport implements ToCollection, WithStartRow{
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows){
        try{
            DB::beginTransaction();
            foreach($rows as $row){
                try{
                    $this->addInterview($row[1], 1, $row[3], $row[12]);
                    $this->addInterview($row[1], 2, $row[4], $row[12]);
                    $this->addInterview($row[1], 3, $row[5], $row[12]);
                    $this->addInterview($row[1], 4, $row[6], $row[12]);
                    $this->addInterview($row[1], 5, $row[7], $row[12]);
                    $this->addInterview($row[1], 6, $row[8], $row[12]);
                    $this->addInterview($row[1], 7, $row[9], $row[12]);
                    $this->addInterview($row[1], 8, $row[10], $row[12]);
                    $this->addInterview($row[1], 9, $row[11], $row[12]);
                }catch(Exception $e){
                    // dd($e->getMessage());
                    throw new Exception("Error on Add Interview Advisor ID: ".$row[1].' '.$e->getMessage());
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    protected function addInterview($advisor_id, $question_id, $answer, $time){
        if( empty($answer) ){
            return '';
        }
        $interview = new Interview();
        $interview->advisor_id          = $advisor_id;
        $interview->interview_question_id= $question_id;
        $interview->answer              = $answer;
        $interview->publication_status  = 1;
        $interview->created_at    	    = Carbon::parse($time)->format('Y-m-d H:i:s');
        $interview->save();
    }
}
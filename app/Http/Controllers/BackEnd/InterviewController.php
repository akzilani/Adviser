<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Interview;
use App\InterviewQuestion;
use App\System;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InterviewController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'question', 'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'question', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new InterviewQuestion();
    }

    /**
     * Show Interview Question List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        //$this->saveActivity($request, "View Advisor Interview List");
        $params = [
            'nav'               => 'interview_question',
            'subNav'            => 'interview_question.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("interview_question_create") ? route('interview_question.create') : false,
            'pageTitle'         => 'Interview Question List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Interview Question",
            "form_url"  => route('interview_question.create'),
        ]; 
        //$this->saveActivity($request, "Advisor Interview Create Page Open");
        return view('backEnd.interview.question-create', $params)->render();
    }

    /**
     * Store Interview Question Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'question'              => ['required','string','min:2', 'max:191'],
                'publication_status' => ['required','numeric']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }    
                $message = "";            
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'Interview question added successfully';
                $this->saveActivity($request, "Add New Advisor Interview Question");
            }else{     
                $message = 'Interview question updated successfully';
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Advisor Interview Question");
            }

            $data->question = $request->question;
            $data->publication_status = $request->publication_status;
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Interview Question Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Interview Question Answer",
            "form_url"  => route('interview_question.create'),
            "data"      => $this->getModel()->find($request->id),
        ];
        //$this->saveActivity($request, "Advisor Interview Edit Page Open");
        return view('backEnd.interview.question-create', $params)->render();
    }


    /**
     * Make the selected Interview Question As Archive
     */
    public function delete(Request $request){
        try{            
            $data = $this->getModel()->find($request->id);
            $data->delete();
            $this->saveActivity($request, "Delete Advisor Interview Question");
            $this->success('Interview question deleted successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Get Interview Question DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable(){
        $data = $this->getModel()->orderBy('id', 'ASC')->get();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })            
            ->addColumn('action', function($row){  
                $li = "";
                if(AccessController::checkAccess("interview_question_update")){
                    $li .= '<a href="'.route('interview_question.edit', [$row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }              
                if(AccessController::checkAccess("interview_question_delete")){
                    $li .= '<a href="'.route('interview_question.delete', [$row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }
                return $li;
            })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status' ])
            ->make(true);
    }

    /**
     * Get Interview Table Column List
     */
    private function getInterviewColumns(){
        $columns = ['#', 'date', 'advisor', 'question', 'answer', 'publication_status', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getInterviewDataTableColumns(){
        $columns = ['index', 'date', 'advisor', 'question', 'answer', 'publication_status', 'action'];
        return $columns;
    }

    /**
     * Interview Answer List
     */
    public function answerList(Request $request){
        if( $request->ajax() ){
            return $this->getAnswerDataTable();
        }
        
        $params = [
            'nav'               => 'interview_question',
            'subNav'            => 'interview_question.answer_list',
            'tableColumns'      => $this->getInterviewColumns(),
            'dataTableColumns'  => $this->getInterviewDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Interview Question Answer List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Get Interview Question's Answer DataTable
     */
    protected function getAnswerDataTable(){
        $data = Interview::orderBy('created_at', 'DESC')->orderby('id', 'DESC')->get();
        $system = System::first();

        return DataTables::of($data)
            ->addColumn('date', function($row)use($system){ return Carbon::parse($row->created_at)->format($system->date_format); })
            ->addColumn('index', function(){ return ++$this->index; })            
            ->addColumn('question', function($row){ return wordwrap($row->interview_question->question, 60, "<br>"); })
            ->addColumn('advisor', function($row){ return $row->advisor->first_name .' '. $row->advisor->last_name; })
            ->editColumn('answer', function($row){ return wordwrap($row->answer, 75, "<br>"); })
            ->addColumn('action', function($row){  
                $li = "";
                if(AccessController::checkAccess("interview_question_answer_update")){
                    $li .= '<a href="'.route('interview_question.answer_edit', [$row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if(AccessController::checkAccess("interview_question_answer_delete")){
                    $li .= '<a href="'.route('interview_question.answer_delete', [$row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }
                return $li;
            })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->rawColumns(['action', 'question', 'answer', 'publication_status' ])
            ->make(true);
    }

    /**
     * Interview Answer Edit
     */
    // public function showAnsEditPage(Request $request){
    //     $data = Interview::find($request->id);
    //     $params = [
    //         "title"     => "Edit Interview",
    //         "form_url" => route('interview_question.answer_edit',[$request->id]),
    //         "questions" => InterviewQuestion::all(),
    //         "data"      => $data,
    //     ];
    //     $this->saveActivity($request, "Update advisor interview question answer ");
    //     return view('backEnd.interview.answer-create', $params);
    // }

    // public function answerUpdate(Request $request){
        
    //     try{            
    //         $data = Interview::find($request->id);
    //         $data->answer       = $request->answer;
    //         $data->interview_question_id = $request->interview_question_id;
    //         $data->publication_status = $request->publication_status;
    //         $data->save();
    //         $this->success('Interview question updated successfully');
    //         $this->saveActivity($request, "Update Advisor Interview Question Answer");
    //     }catch(Exception $e){
    //         $this->message = $this->getError($e);
    //     }
    //     return $this->output();
    // }
        public function showAnsEditPage(Request $request){
        $data = Interview::find($request->id);
        $params = [
            "title"     => "Edit Interview",
            "form_url" => route('interview_question.answer_edit',[$request->id]),
            "questions" => InterviewQuestion::all(),
            "data"      => $data,
        ];
       // $this->saveActivity($request, "Edit Advisor Interview Question Answer");
        return view('backEnd.interview.answer-create', $params);
    }

    public function answerUpdate(Request $request){

        try{
            $data = Interview::find($request->id);
            $data->answer       = $request->answer;
            $data->interview_question_id = $request->interview_question_id;
            $data->publication_status = $request->publication_status;
            $data->save();
            $this->success('Interview question updated successfully');
            $this->saveActivity($request, "Update Advisor Interview Question Answer");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }


    /**
     * Delete Answer
     */
    public function deleteAnswer(Request $request){
        try{            
            $data = Interview::where('id', $request->id)->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Advisor Interview Question Answer");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }
    
    


    
}

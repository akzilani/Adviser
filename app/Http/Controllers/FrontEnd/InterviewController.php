<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Interview;
use App\InterviewQuestion;
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
        $columns = ['#', 'question', 'answer', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'question', 'answer', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Interview();
    }

    /**
     * Show Testimonial List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable($request);
        }
        
        //$this->saveActivity($request, "Advisor Interview Table Show");
        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.interview',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('advisor.interview.create'),
            'pageTitle'         => 'Interview List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-lg",
        ];
        return view('frontEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $interviewed_qs = $this->getModel()->where('advisor_id', $request->user()->id)->select('interview_question_id')->pluck("interview_question_id")->toArray();
        $params = [
            "title"     => "Create Interview",
            "questions" => InterviewQuestion::whereNotIn('id', $interviewed_qs)->get(),
            "form_url"  => route('advisor.interview.create'),
        ]; 
        $this->saveActivity($request, "Create Advisor Interview Page Open");
        return view('frontEnd.advisor.interview.create', $params)->render();
    }

    /**
     * Store Testimonial Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'interview_question_id' => ['required', 'numeric','min:1'],
                'answer'                 => ['required', 'string','min:2'],
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }                
                $data = $this->getModel();
                $this->saveActivity($request, "Add New Advisor Interview");
            }else{
                $data = $this->getModel()->find($request->id);
                $this->saveActivity($request, "Update Advisor Interview", $data);
            }

            $data->advisor_id   = $request->user()->id;
            $data->answer       = $request->answer;
            $data->interview_question_id = $request->interview_question_id;
            $data->publication_status = $request->publication_status;
            $data->save();
            $this->success('Interview added successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit
     */
    public function edit(Request $request){
        $data = $this->getModel()->find($request->id);
        $interviewed_qs = $this->getModel()->where('advisor_id', $request->user()->id)->select('interview_question_id')->pluck("interview_question_id")->toArray();
        $arr_key = array_search($data->interview_question_id, $interviewed_qs);     
        unset($interviewed_qs[$arr_key]);
        $params = [
            "title"     => "Edit Interview",
            "form_url"  => route('advisor.interview.create'),
            "questions" => InterviewQuestion::whereNotIn('id', $interviewed_qs)->get(),
            "data"      => $data,
        ]; 
        //$this->saveActivity($request, "Edit Advisor Interview Page Open");
        return view('frontEnd.advisor.interview.create', $params)->render();
    }

    /**
     * Delete
     */
    public function delete(Request $request){
        $this->getModel()->where('id', $request->id)->delete();
        $this->success("Deleted successfully");
        $this->saveActivity($request, "Delete Advisor Interview");
        return $this->output();
    }

    /**
     * Get Complance   DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($request){
        $data = $this->getModel()->where('advisor_id', $request->user()->id)->orderBy('id', 'ASC')->get();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('question', function($row){ return wordwrap($row->interview_question->question, 60, "<br>"); })
            ->editColumn('answer', function($row){ return wordwrap($row->answer, 75, "<br>"); })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->addColumn('action', function($row){                
                $li = '<a href="'.route('advisor.interview.edit', [$row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                $li .= '<a href="'.route('advisor.interview.delete', [$row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                return $li;
            })           
            ->rawColumns(['action', 'publication_status', 'answer', 'question'])
            ->make(true);
    }
}

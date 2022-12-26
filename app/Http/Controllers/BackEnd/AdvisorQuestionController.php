<?php

namespace App\Http\Controllers\BackEnd;

use App\AdvisorQuestion;
use App\Http\Components\Classes\MatchRating;
use App\Http\Controllers\Controller;
use App\Question;
use App\ServiceOffer;
use App\System;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class AdvisorQuestionController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'date', 'advisor', 'service_offer', 'question', 'answer', 'visibility', 'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'date','advisor', 'service_offer','question', 'answer', 'visibility', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new AdvisorQuestion();
    }

    /**
     * Show advisorQuestion List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        //$this->saveActivity($request, "View Advisor Question List");
        $params = [
            'nav'               => 'advisorQuestion',
            'subNav'            => 'advisorQuestion.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("advisorQuestion_create") ? route('advisorQuestion.create') : false,
            'pageTitle'         => 'Advisor Case Studies List',
            'tableStyleClass'   => 'bg-success',
            'table_responsive'  => "table-responsive",
            
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Case Study",
            "form_url"  => route('advisorQuestion.create'),
            'service_offer' => ServiceOffer::where('publication_status', 1)->get(),
            'advisors' => User::all(),
        ]; 
       // $this->saveActivity($request, "Advisor Question's Create Page Open");
        return view('backEnd.question.advisor-question', $params)->render();
    }

    /**
     * Store advisorQuestion Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                "question"              =>['required','numeric','min:1'],  
                "service_offer_id"      =>['required','numeric','min:1'],
                'question'              => ['required','string'],
                'answer'                => ['required','string'],
                'publication_status'    => ['required','numeric'],
                'visibility'            => ['required','string', 'min:6', 'max:7']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = "Advisor question added successfully";
                $this->saveActivity($request, "Add New Advisor Question");
            }else{
                $message = "Advisor question updated successfully";
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Advisor Question");
            }
            $advisor = User::find($request->advisor_id);
            $data->advisor_id           = $advisor->id;            
            $data->question             = $request->question;            
            $data->service_offer_id     = $request->service_offer_id;            
            $data->answer               = $request->answer;                        
            $data->publication_status   = $request->publication_status;
            $data->visibility           = $request->visibility;
            $data->save();
            (new MatchRating($advisor))->handel();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit advisorQuestion Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Advisor Question",
            "form_url"  => route('advisorQuestion.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
            'service_offer' => ServiceOffer::where('publication_status', 1)->get(),
            'advisors' => User::all(),
        ];
        //$this->saveActivity($request, "Edit Advisor Question's page open");
        return view('backEnd.question.advisor-question', $params)->render();
    }


    /**
     * Make the selected advisorQuestion As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $this->saveActivity($request, "Delete Advisor Question");
            $data->delete();
            $this->success('Archive updated successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected advisorQuestion As Active from Archive
     */
    public function restore(Request $request){
        try{
            $this->saveActivity($request, "Restore Advisor Question");
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Advisor question restored successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Advisor QuestionList
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        
        $params = [
            'nav'               => 'advisorQuestion' ,
            'subNav'            => 'advisorQuestion.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Advisor Question Archive List',
            'tableStyleClass'   => 'bg-success',
            "table_responsive"  => "table-responsive",
            "max_width"         => "100px"
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Get advisorQuestion DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('id', 'desc')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('id', 'desc')->get();
        }
        $system = System::first();
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('advisor', function($row){ return isset($row->advisor->first_name) ? ($row->advisor->first_name . ' ' . $row->advisor->last_name) : "N/A"; })
            ->addColumn('service_offer', function($row){ return isset($row->service_offer->name) ? ($row->service_offer->name) : "N/A"; })
            ->editColumn('question', function($row){ return wordwrap($row->question ?? "", "35", "<br>"); })
            ->editColumn('visibility', function($row){ return $this->getStatus($row->visibility); })
            ->addColumn('action', function($row) use($type){  
                $li = "";
                if(AccessController::checkAccess('advisorQuestion_update')){
                    $li = '<a href="'.route('advisorQuestion.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if(AccessController::checkAccess('advisorQuestion_delete')) {
                    if($type == 'list'){
                        $li .= '<a href="'.route('advisorQuestion.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                } 
                if(AccessController::checkAccess('advisorQuestion_restore')) {
                    if($type != 'list'){
                        $li .= '<a href="'.route('advisorQuestion.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                } 
                return $li;
            })  
            ->editColumn("answer", function($row){
                return wordwrap($row->answer, "65", "<br>");
            })          
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->addColumn('date', function($row) use ($system){
                return Carbon::parse($row->created_at)->format($system->date_format);
            })
            ->rawColumns(['action', 'publication_status', "answer", "question", "visibility" ])
            ->make(true);
    }

    
}

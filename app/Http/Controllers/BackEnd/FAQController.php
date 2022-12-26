<?php

namespace App\Http\Controllers\BackEnd;

use App\AdvisorFaq;
use App\page;
use App\Http\Controllers\Controller;
use App\Pages;
use App\System;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FAQController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        /*$columns = ['#', 'sn', 'question', 'answer','publication_status', 'created_by', 'updated_by', 'action'];*/
        $columns = ['sn', 'question', 'answer','publication_status', 'created_by', 'updated_by', 'action'];
        
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        /*$columns = ['index', 'faq_sl','question', 'answer','publication_status', 'created_by', 'updated_by', 'action'];*/
        $columns = ['faq_sl','question', 'answer','publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new AdvisorFaq();
    }

    /**
     * Show page List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "FAQ Table Show");
        $params = [
            'nav'               => 'faq',
            'subNav'            => 'faq.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("faq_create") ? route('faq.create') : false,
            'pageTitle'         => 'FAQ List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-lg"
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create FAQ",
            "form_url"  => route('faq.create'),
        ]; 
        //$this->saveActivity($request, "Create FAQ Page Open");
        return view('backEnd.faq.create', $params)->render();
    }

    /**
     * Store page Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'question'  => ['required','string','min:4'],
                'answer'    => ['required','string'],
                'faq_sl'    => ['required','numeric'],
                'publication_status' => ['required','numeric']
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'FAQ added successfully';
                $this->saveActivity($request, "Add new FAQ ");
            }else{
                $message = 'FAQ updated successfully';
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update FAQ", $data);
            }
            
            $data->question = $request->question;
            $data->answer = $request->answer; 
            $data->faq_sl = $request->faq_sl;
            $data->publication_status = $request->publication_status;
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit page Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit FAQ  ",
            "form_url"  => route('faq.create'),
            "data"      => $this->getModel()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit FAQ Page Open");
        return view('backEnd.faq.create', $params)->render();
    }

    /**
     * View page Message
     */
    public function view(Request $request){
        $params = [
            "data"      => $this->getModel()->find($request->id)
        ];
        return view('backEnd.faq.view', $params)->render();
    }


    /**
     * Make the selected page   As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete FAQ");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected page   As Active from Archive
     */
    public function restore(Request $request){
        try{
            $this->saveActivity($request, "Restore FAQ");
            $data = $this->getModel()->find($request->id);
            $data->restore();
            $this->success('FAQ restored successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive page   List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        
        $params = [
            'nav'               => 'subscription' ,
            'subNav'            => 'faq.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'FAQ Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.faq.table', $params);
    }

    /**
     * Get page   DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('faq_sl', 'ASC')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('faq_sl', 'ASC')->get();
        }
        $system = System::first();
        return DataTables::of($data)
            /*->addColumn('index', function(){ return ++$this->index; })*/
            ->editColumn("answer", function($row){ return wordwrap($row->answer, "60", "<br>"); })
            ->editColumn("question", function($row){ return wordwrap($row->question, "60", "<br>"); })
            ->editColumn("faq_sl", function($row){ return wordwrap($row->faq_sl, "60", "<br>"); })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->addColumn('action', function($row) use($type){                
                $li = "";
                if(AccessController::checkAccess("faq_update")){
                    $li .= '<a href="'.route('faq.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if($type == 'list'){
                    if(AccessController::checkAccess("faq_delete")){
                        $li .= '<a href="'.route('faq.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }                    
                }else{
                    if(AccessController::checkAccess("faq_restore")){
                        $li .= '<a href="'.route('faq.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                }
                return $li;
            })            
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'faq_sl', 'answer', "question" ])
            ->make(true);
    }

    
}

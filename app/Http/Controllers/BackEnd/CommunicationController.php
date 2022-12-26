<?php

namespace App\Http\Controllers\BackEnd;

use App\Communication;
use App\Http\Controllers\Controller;
use App\System;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CommunicationController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'date', 'advisor', "region", 'subject','time', 'action'];
        //$columns = ['#', 'date', 'advisor', "region", 'subject', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'date', 'advisor', "region", 'subject','time', 'action'];
        //$columns = ['index', 'date', 'advisor', "region", 'subject', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Communication();
    }

    /**
     * Show Communication List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        //$this->saveActivity($request, "Communication Table Page Open");
        $params = [
            'nav'               => 'communication',
            'subNav'            => 'communication.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("communication_create") ? route('communication.create') : false,
            'pageTitle'         => 'Communication List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-lg"
        ];
        return view('backEnd.communication-table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Communication",
            "form_url"  => route('communication.create'),
            "advisors"  => User::all(),
        ]; 
        //$this->saveActivity($request, "Create Communication Page Open");
        return view('backEnd.communication.create', $params)->render();
    }

    /**
     * Store Communication Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'advisor_id'    => ['required','numeric','min:1'],
                'subject'       => ['required','string','min:2', 'max:100'],
                'message'       => ['required','string','min:2', 'max:1000'],
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'Communication information added successfully';
                $this->saveActivity($request, "Add new advisor communication ");
            }else{
                $message = 'Communication information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update advisor communication ", $data);
            }

            $data->advisor_id = $request->advisor_id;
            $data->subject = $request->subject;
            $data->message = $request->message;
            $data->publication_status = 1;
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Communication Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Communication  ",
            "form_url"  => route('communication.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
            "advisors"  => User::all(),
        ];
        //$this->saveActivity($request, "Edit Communication Page Open");
        return view('backEnd.communication.create', $params)->render();
    }

    /**
     * View Communication Message
     */
    public function view(Request $request){
        $params = [
            "data"      => $this->getModel()->withTrashed()->find($request->id)
        ];
        return view('backEnd.communication.view', $params)->render();
    }


    /**
     * Make the selected Communication   As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete advisor communication ");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Communication   As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Communication restored successfully');
            $this->saveActivity($request, "Restore advisor communication ");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Communication   List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        
        $params = [
            'nav'               => 'subscription' ,
            'subNav'            => 'communication.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Communication Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.communication.table', $params);
    }

    /**
     * Get Communication   DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('id', 'DESC')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('id', 'ASC')->get();
        }
        $system = System::first();
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('advisor', function($row){ return ($row->advisor->first_name ?? "N/A"). ' ' . ($row->advisor->last_name ?? ""); })
            ->addColumn("region", function($row){ return $row->advisor->primary_reason->name ?? ""; })
            
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('communication.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Message" > <span class="fa fa-eye"></span> </a> ';
                if(AccessController::checkAccess("communication_update")){
                    $li .= '<a href="'.route('communication.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if($type == 'list'){
                    if(AccessController::checkAccess("communication_delete")){
                        $li .= '<a href="'.route('communication.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }                    
                }else{
                    if(AccessController::checkAccess("communication_restore")){
                        $li .= '<a href="'.route('communication.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                }
                return $li;
            })
            ->addColumn('date', function($row)use($system){ return Carbon::parse($row->created_at)->format($system->date_format); })
            ->addColumn('time', function($row)use($system){ return Carbon::parse($row->created_at)->format('H:i:s'); })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status' ])
            ->make(true);
    }

    
}

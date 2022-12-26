<?php

namespace App\Http\Controllers\BackEnd;

use App\FetchfyConfiguration;
use App\Http\Controllers\Controller;
use App\System;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FetchfyConfigurationController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'page', 'status', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'page', 'status', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new FetchfyConfiguration();
    }

    /**
     * Show page List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "Fetchfy Configuration Table Show");
        $params = [
            'nav'               => 'fetchfy_configuration',
            'subNav'            => 'fetchfy_configuration.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("fetchfy_configuration_create") ? route('fetchfy_configuration.create') : false,
            'pageTitle'         => 'Fetchfy Configuration List',
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
            "title"     => "Create page",
            "form_url"  => route('fetchfy_configuration.create'),
        ]; 
        //$this->saveActivity($request, "Create Fetchfy Configuration Page Open");
        return view('backEnd.fetchfy_configuration.create', $params)->render();
    }

    /**
     * Store page Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'page'      => ['required','string','min:2'],
                "status"    => ['required', "boolean"]
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'Fetchfy Configuration added successfully';
                $this->saveActivity($request, "Add New Fetchfy Configuration");
            }else{
                $message = 'Fetchfy Configuration updated successfully';
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Fetchfy Configuration Data", $data);
            }

            $data->page = $request->page;
            $data->status = $request->status;
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
            "title"     => "Edit page  ",
            "form_url"  => route('fetchfy_configuration.create'),
            "data"      => $this->getModel()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit Fetchfy Configuration Page Open");
        return view('backEnd.fetchfy_configuration.create', $params)->render();
    }

    /**
     * View page Message
     */
    public function view(Request $request){
        $params = [
            "data"      => $this->getModel()->find($request->id)
        ];
        return view('backEnd.fetchfy_configuration.view', $params)->render();
    }


    /**
     * Make the selected page   As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Fetchfy Configuration");
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
            
            $data = $this->getModel()->find($request->id);
            $data->restore();
            $this->success('Fetchfy Configuration restored successfully');
            $this->saveActivity($request, "Restore Fetchfy Configuration");
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
            'subNav'            => 'fetchfy_configuration.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'page Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.fetchfy_configuration.table', $params);
    }

    /**
     * Get page   DataTable
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
            ->addColumn('action', function($row) use($type){                
                $li = "";
                if(AccessController::checkAccess("fetchfy_configuration_update")){
                    $li .= '<a href="'.route('fetchfy_configuration.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if($type == 'list'){
                    if(AccessController::checkAccess("fetchfy_configuration_delete")){
                        $li .= '<a href="'.route('fetchfy_configuration.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }                    
                }else{
                    if(AccessController::checkAccess("fetchfy_configuration_restore")){
                        $li .= '<a href="'.route('fetchfy_configuration.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                }
                return $li;
            })            
            ->editColumn("page", function($row){ return ucfirst($row->page)." Page"; })
            ->editColumn("status", function($row){ return $row->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'status' ])
            ->make(true);
    }

    
}

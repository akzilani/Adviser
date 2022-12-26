<?php

namespace App\Http\Controllers\BackEnd;

use App\AdvisorType;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class AdvisorTypeController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new AdvisorType();
    }

    /**
     * Show advisorType List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        //$this->saveActivity($request, "View Advisor type List");
        $params = [
            'nav'               => 'advisorType',
            'subNav'            => 'advisorType.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("advisorType_create") ? route('advisorType.create') : false,
            'pageTitle'         => 'Advisor Type List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(){
        $params = [
            "title"     => "Create Advisor Type",
            "form_url"  => route('advisorType.create'),
        ]; 
        return view('backEnd.advisorType.create', $params)->render();
    }

    /**
     * Store advisorType Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name'              => ['required','string','min:2', "max:191" ],
                'publication_status'=> ['required','numeric']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $message = 'Advisor type information added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "New Advisor type added");
            }else{
                $message = 'Advisor type information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Advisor type added", $data);
            }

            $data->name = $request->name;
            $data->publication_status = $request->publication_status;
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit advisorType Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Advisor Type",
            "form_url"  => route('advisorType.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
        ];
        
        return view('backEnd.advisorType.create', $params)->render();
    }


    /**
     * Make the selected advisorType As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Advisor type");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected advisorType As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Advisor type restored successfully');
            $this->saveActivity($request, "Restore Advisor type");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive advisorType List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        $this->saveActivity($request, "Show Deleted Advisor type");
        $params = [
            'nav'               => 'advisorType' ,
            'subNav'            => 'advisorType.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Advisor Type Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.advisorType.table', $params);
    }

    /**
     * Get advisorType DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('id', 'asc')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('id', 'asc')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('advisorType.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    if(AccessController::checkAccess("advisorType_delete")){
                        $li .= '<a href="'.route('advisorType.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }                    
                }else{
                    if(AccessController::checkAccess("advisorType_restore")){
                        $li .= '<a href="'.route('advisorType.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                }
                return $li;
            })
            ->editColumn("person_range", function($row){ return $row->min_range . ' - '. $row->max_range .' Person';})
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status' ])
            ->make(true);
    }

    
}

<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\PrimaryReason;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class PrimaryReasonController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'position', 'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'position', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new PrimaryReason();
    }

    /**
     * Show primaryReason List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "Create Primary Reason List");
        $params = [
            'nav'               => 'primaryReason',
            'subNav'            => 'primaryReason.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("primaryReason_create") ? route('primaryReason.create') : false,
            'pageTitle'         => 'Primary Region List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Primary Region",
            "form_url"  => route('primaryReason.create'),
        ]; 
        //$this->saveActivity($request, "Create Primary Reason Page Open");
        return view('backEnd.primaryReason.create', $params)->render();
    }

    /**
     * Store primaryReason Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name'  => ['required','string','min:0', 'max:100'],
                'publication_status' => ['required','numeric']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $message = 'Primary region added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Primary region added ");
            }else{
                $message = 'Primary region updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                
                $this->saveActivity($request, "Primary region updated ");
            }

            $data->name = $request->name;            
            $data->position = $request->position;            
            $data->publication_status = $request->publication_status;
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit primaryReason Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Primary Region",
            "form_url"  => route('primaryReason.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
        ];
      //  $this->saveActivity($request, "Primary region updated");
        return view('backEnd.primaryReason.create', $params)->render();
    }


    /**
     * Make the selected primaryReason As Archive
     */
    public function archive(Request $request){
        try{
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Primary region deleted ");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected primaryReason As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Primary region restored successfully');
            $this->saveActivity($request, "Restore Primary Reason");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Primary Region List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        //$this->saveActivity($request, "View Deleted Primary Reason");
        $params = [
            'nav'               => 'primaryReason' ,
            'subNav'            => 'primaryReason.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Primary Region Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.primaryReason.table', $params);
    }

    /**
     * Get primaryReason DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('position', 'ASC')->get();
        }else{
            $data = $this->getModel()->orderBy('position', 'ASC')->onlyTrashed()->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('action', function($row) use($type){  
                $li = "";
                if(AccessController::checkAccess("primaryReason_update")){
                    $li = '<a href="'.route('primaryReason.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }              
                
                if($type == 'list'){
                    if(AccessController::checkAccess("primaryReason_delete")){
                        $li .= '<a href="'.route('primaryReason.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }                    
                }else{
                    if(AccessController::checkAccess("primaryReason_restore")){
                        $li .= '<a href="'.route('primaryReason.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
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

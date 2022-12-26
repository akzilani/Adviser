<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Profession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProfessionController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'description', 'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'description', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Profession;
    }

    /**
     * Show Profession List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "View Profession Table");
        $params = [
            'nav'               => 'profession',
            'subNav'            => 'profession.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("profession_create") ? route('profession.create') : false,
            'pageTitle'         => 'Profession List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Profession",
            "form_url"  => route('profession.create'),
        ]; 
        //$this->saveActivity($request, "Add Profession Page Open");
        return view('backEnd.profession.create', $params)->render();
    }

    /**
     * Store Profession Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name'          => ['required','string','min:2', 'max:100'],
                'publication_status' => ['required','numeric']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $message = 'Profession information added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Add New Profession");
            }else{
                $message = 'Profession information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Profession", $data);
            }

            $data->name = $request->name;
            $data->publication_status = $request->publication_status;
            $data->description = $request->description;
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Profession Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Profession",
            "form_url"  => route('profession.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit Profession Page Open");
        return view('backEnd.profession.create', $params)->render();
    }


    /**
     * Make the selected Profession As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Profession");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Profession As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Profession restored successfully');
            $this->saveActivity($request, "Restore Profession");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Profession List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        //$this->saveActivity($request, "View Deleted Profession List");
        $params = [
            'nav'               => 'profession' ,
            'subNav'            => 'profession.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Profession Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.profession.table', $params);
    }

    /**
     * Get Profession DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('id', 'ASC')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('id', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })            
            ->addColumn('role', function($row){ return ucfirst(str_replace('_',' ', $row->user_type)); })
            ->addColumn('action', function($row) use($type){ 
                $li = "";
                if(AccessController::checkAccess("profession_update")){
                    $li = '<a href="'.route('profession.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }  
                if($type == 'list'){
                    if(AccessController::checkAccess("profession_delete")){
                        $li .= '<a href="'.route('profession.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("profession_restore")){
                        $li .= '<a href="'.route('profession.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                }
                return $li;
            })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status' ])
            ->make(true);
    }

    
}

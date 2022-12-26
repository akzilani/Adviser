<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\LocationPostCodes;
use App\PrimaryReason;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class LocationPostCodeController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', "reason", 'short_name', "full_name",'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'reason', 'short_name', "full_name", 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new LocationPostCodes();
    }

    /**
     * Show postcode List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "View Primary PostCode Tables");
        $params = [
            'nav'               => 'postcode',
            'subNav'            => 'postcode.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("postcode_create") ? route('postcode.create') : false,  
            'pageTitle'         => 'Primary Postcode List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Primary Postcode",
            "form_url"  => route('postcode.create'),
            "reasons"   => PrimaryReason::where('publication_status', true)->orderBy("position", "ASC")->get(),
        ]; 
        //$this->saveActivity($request, "Create Primary PostCode Page Open");
        return view('backEnd.postcode.create', $params)->render();
    }

    /**
     * Store postcode Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'full_name'  => ['required','string','min:0', 'max:100'],
                "short_name" => ['required','string','min:0', 'max:100'],
                "primary_region_id" => ['required','numeric','min:1'],
                'publication_status' => ['required','numeric']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $message = 'Primary postcode added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Add New Primary PostCode");
            }else{
                $message = 'Primary postcode updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Primary PostCode");
            }

            $data->full_name = $request->full_name;            
            $data->short_name = $request->short_name;            
            $data->primary_region_id = $request->primary_region_id;            
            $data->publication_status = $request->publication_status;
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit postcode Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Primary Postcode",
            "form_url"  => route('postcode.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
            "reasons"   => PrimaryReason::where('publication_status', true)->orderBy("position", "ASC")->get(),
        ];
        //$this->saveActivity($request, "Edit Primary PostCode Page Open");
        return view('backEnd.postcode.create', $params)->render();
    }


    /**
     * Make the selected postcode As Archive
     */
    public function archive(Request $request){
        try{
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Primary postcode deleted ");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected postcode As Active from Archive
     */
    public function restore(Request $request){
        try{
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Primary postcode restored successfully');
            $this->saveActivity($request, "Restore Primary PostCode");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Location Postcode List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        //$this->saveActivity($request, "View Deleted Primary PostCode");
        $params = [
            'nav'               => 'postcode' ,
            'subNav'            => 'postcode.deleted_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Primary Postcode Deleted List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Get postcode DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        $data = $this->getModel()->join('primary_reasons as PR', 'PR.id', '=', 'location_post_codes.primary_region_id')
            ->select('PR.name as reason', "location_post_codes.*")    
            ->orderBy('short_name', 'ASC')->orderBy('full_name', 'ASC');
        if( $type == "list" ){
            $data = $data->get();
        }else{
            $data = $data->onlyTrashed()->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('action', function($row) use($type){   
                $li = "";
                if(AccessController::checkAccess("postcode_update")){
                    $li = '<a href="'.route('postcode.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if($type == 'list'){
                    if(AccessController::checkAccess("postcode_delete")){
                        $li .= '<a href="'.route('postcode.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("postcode_restore")){
                        $li .= '<a href="'.route('postcode.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
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

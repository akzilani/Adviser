<?php

namespace App\Http\Controllers\BackEnd;

use App\FirmSize;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class FirmSizeController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'person_range', 'amount', 'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'person_range', 'amount', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new FirmSize;
    }

    /**
     * Show firmSize List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        $params = [
            'nav'               => 'firmSize',
            'subNav'            => 'firmSize.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("firmSize_create") ? route('firmSize.create') : false,
            'pageTitle'         => 'Firm Size List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Firm Size",
            "form_url"  => route('firmSize.create'),
        ]; 
       // $this->saveActivity($request, "Add Firm Size Page Open");
        return view('backEnd.firmSize.create', $params)->render();
    }

    /**
     * Store firmSize Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'min_range'  => ['required','numeric','min:0', 'max:100'],
                'max_range'  => ['required','numeric','min:1', 'max:100000'],
                'amount'     => ['required','numeric','min:1' ],
                'publication_status' => ['required','numeric']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $message = 'Firm size information added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Add New Firm Size");
            }else{
                $message = 'Firm size information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Firm Size", $data);
            }

            $data->min_range = $request->min_range;
            $data->max_range = $request->max_range;
            $data->publication_status = $request->publication_status;
            $data->amount = $request->amount;
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit firmSize Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Create Firm Size",
            "form_url"  => route('firmSize.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit Firm Size Page Open");
        return view('backEnd.firmSize.create', $params)->render();
    }


    /**
     * Make the selected firmSize As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Firm Size");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected firmSize As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Firm size restored successfully');
            $this->saveActivity($request, "Restore Firm Size");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive firmSize List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        
        $params = [
            'nav'               => 'firmSize' ,
            'subNav'            => 'firmSize.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Firm Size Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.firmSize.table', $params);
    }

    /**
     * Get firmSize DataTable
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
            ->addColumn('action', function($row){  
                if(AccessController::checkAccess("firmSize_update")){
                    $li = '<a href="'.route('firmSize.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
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

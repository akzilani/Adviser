<?php

namespace App\Http\Controllers\BackEnd;

use App\FundSize;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class FundSizeController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'amount', 'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'min_fund', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new FundSize();
    }

    /**
     * Show fundSize List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        //$this->saveActivity($request, "View Fund Size Table");
        $params = [
            'nav'               => 'fundSize',
            'subNav'            => 'fundSize.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("fundSize_create") ? route('fundSize.create') : false,
            'pageTitle'         => 'Fund Size List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Fund Size",
            "form_url"  => route('fundSize.create'),
        ]; 
        //$this->saveActivity($request, "Add Fund Size Page Open");
        return view('backEnd.fundSize.create', $params)->render();
    }

    /**
     * Store fundSize Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name'      => ['STRING','min:2', 'max:191'],
                'min_fund'  => ['required','numeric','min:1', 'max:100000000000'],
                'publication_status' => ['required','numeric']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $message = 'Fund size information added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Add New Fund Size");
            }else{
                $message = 'Fund size information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update New Fund Size", $data);
            }

            $data->min_fund = $request->min_fund;
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
     * Edit fundSize Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Fund Size",
            "form_url"  => route('fundSize.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit New Fund Size Page Open");
        return view('backEnd.fundSize.create', $params)->render();
    }


    /**
     * Make the selected fundSize As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Fund Size");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected fundSize As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Fund size restored successfully');
            $this->saveActivity($request, "Restore Fund Size");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive fundSize List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        //$this->saveActivity($request, "View Deleted Fund Size Table");
        $params = [
            'nav'               => 'fundSize' ,
            'subNav'            => 'fundSize.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Fund Size Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.fundSize.table', $params);
    }

    /**
     * Get fundSize DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('min_fund', 'ASC')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('id', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('action', function($row) use($type){ 
                if(AccessController::checkAccess("fundSize_update")){
                    $li = '<a href="'.route('fundSize.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if($type == 'list'){
                    if(AccessController::checkAccess("fundSize_delete")){
                        $li .= '<a href="'.route('fundSize.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("fundSize_restore")){
                        $li .= '<a href="'.route('fundSize.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
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

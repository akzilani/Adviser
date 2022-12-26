<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\SubscribePrimaryReason;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class SubscriptionPrimaryReasonController extends Controller
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
        return new SubscribePrimaryReason();
    }

    /**
     * Show subscribePrimaryReason List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        //$this->saveActivity($request, "View Subscribe Primary Reason");
        $params = [
            'nav'               => 'subscribePrimaryReason',
            'subNav'            => 'subscribePrimaryReason.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("subscribePrimaryReason_create") ? route('subscribePrimaryReason.create') : false,
            'pageTitle'         => 'Subscriptions Regions List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Subscription Region",
            "form_url"  => route('subscribePrimaryReason.create'),
        ]; 
        //$this->saveActivity($request, "Create Subscribe Primary Reason Page Open");
        return view('backEnd.subscribePrimaryReason.create', $params)->render();
    }

    /**
     * Store subscribePrimaryReason Information
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
                $message = 'Subscription region added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Added new subscription region ");
            }else{
                $message = 'Subscription region updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Updated subscription region ", $data);
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
     * Edit subscribePrimaryReason Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit  Primary Subscription Locations",
            "form_url"  => route('subscribePrimaryReason.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit Subscribe Primary Reason Page Open");
        return view('backEnd.subscribePrimaryReason.create', $params)->render();
    }


    /**
     * Make the selected subscribePrimaryReason As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Deleted subscription region");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected subscribePrimaryReason As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success(' Subscription region restored successfully');
            $this->saveActivity($request, "Restore Subscribe Primary Reason");
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

        //$this->saveActivity($request, "View Deleted Subscribe Primary Reason"); 
        $params = [
            'nav'               => 'subscribePrimaryReason' ,
            'subNav'            => 'subscribePrimaryReason.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => ' Primary Subscription Locations Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Get subscribePrimaryReason DataTable
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
                if(AccessController::checkAccess("subscribePrimaryReason_update")){
                    $li = '<a href="'.route('subscribePrimaryReason.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }             
                
                if($type == 'list'){
                    if(AccessController::checkAccess("subscribePrimaryReason_delete")){
                        $li .= '<a href="'.route('subscribePrimaryReason.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                    
                }else{
                    if(AccessController::checkAccess("subscribePrimaryReason_restore")){
                        $li .= '<a href="'.route('subscribePrimaryReason.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
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

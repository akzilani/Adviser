<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\SubscribePostCodes;
use App\SubscribePrimaryReason;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class SubscribePostCodeController extends Controller
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
        return new SubscribePostCodes();
    }

    /**
     * Show postcode List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        //$this->saveActivity($request, "View Subscribe PostCode Table");
        $params = [
            'nav'               => 'subscribePostcode',
            'subNav'            => 'subscribePostcode.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("subscribePostcode_create") ? route('subscribePostcode.create') : false,
            'pageTitle'         => 'Subscription Postcode Lists',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Subscription Postcode",
            "form_url"  => route('subscribePostcode.create'),
            "reasons"   => SubscribePrimaryReason::where('publication_status', true)->orderBy("position", "ASC")->get(),
        ]; 
        //$this->saveActivity($request, "Create Subscribe PostCode Page Open");
        return view('backEnd.subscribePostcode.create', $params)->render();
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
                $message = 'Subscription postcode added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Added new subscription postcode ");
            }else{
                $message = 'Subscription postcode updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Updated subscription postcode ", $data);
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
            "title"     => "Edit Subscription Postcode",
            "form_url"  => route('subscribePostcode.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
            "reasons"   => SubscribePrimaryReason::where('publication_status', true)->orderBy("position", "ASC")->get(),
        ];
       // $this->saveActivity($request, "Edit Subscribe PostCode Page Open");
        return view('backEnd.subscribePostcode.create', $params)->render();
    }


    /**
     * Make the selected postcode As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Deleted subscription postcode ");
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
            $this->success('Subscription postcode has restored successfully');
            $this->saveActivity($request, "Restore Subscribe PostCode");
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
        
        //$this->saveActivity($request, "View Deleted Subscribe PostCode Table");
        $params = [
            'nav'               => 'Subscribe' ,
            'subNav'            => 'subscribePostcode.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Subscription Postcode Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.subscribePostcode.table', $params);
    }

    /**
     * Get postcode DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        $data = $this->getModel()->join('subscribe_primary_reasons as SPR', 'SPR.id', '=', 'subscribe_post_codes.primary_region_id')
            ->select('SPR.name as reason', "subscribe_post_codes.*")    
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
                if(AccessController::checkAccess("subscribePostcode_update")){
                    $li = '<a href="'.route('subscribePostcode.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if($type == 'list'){
                    if(AccessController::checkAccess("subscribePostcode_delete")){
                        $li .= '<a href="'.route('subscribePostcode.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("subscribePostcode_restore")){
                        $li .= '<a href="'.route('subscribePostcode.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
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

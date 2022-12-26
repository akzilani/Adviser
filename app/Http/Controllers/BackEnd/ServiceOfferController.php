<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\ServiceOffer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class ServiceOfferController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'image', 'name', "description",'position','publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'image', 'name', "description",'position','publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new ServiceOffer();
    }

    /**
     * Show serviceOffer List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "View");
        $params = [
            'nav'               => 'serviceOffer',
            'subNav'            => 'serviceOffer.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("serviceOffer_create") ? route('serviceOffer.create') : false,
            'pageTitle'         => 'Areas of Advice List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Areas of Advice",
            "form_url"  => route('serviceOffer.create'),
        ]; 
        //$this->saveActivity($request, "View Area of Advice Page Open");
        return view('backEnd.serviceOffer.create', $params)->render();
    }

    /**
     * Store serviceOffer Information
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
                $message = 'Areas of advice added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Add New Area of Advice");
            }else{
                $message = 'Areas of advice updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Area of Advice");
            }

            $data->name = $request->name;            
            $data->description = $request->description;       
            $data->position = $request->position;       
            $data->publication_status = $request->publication_status;
            $data->image = $this->uploadImage($request, 'image', $this->others_dir, null, null, $data->image);
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit serviceOffer Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Areas of Advice",
            "form_url"  => route('serviceOffer.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit Area of Advice Page Open");
        return view('backEnd.serviceOffer.create', $params)->render();
    }


    /**
     * Make the selected serviceOffer As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Area of Advice");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected serviceOffer As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Areas of advice restored successfully');
            $this->saveActivity($request, "Restore Area of Advice");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Service OfferList
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        //$this->saveActivity($request, "View Deleted Area of Advice");
        $params = [
            'nav'               => 'serviceOffer' ,
            'subNav'            => 'serviceOffer.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Areas of Advice Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.serviceOffer.table', $params);
    }

    /**
     * Get serviceOffer DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('position', 'ASC')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('position', 'ASC')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('action', function($row) use($type){    
                $li = "";
                if(AccessController::checkAccess("serviceOffer_update")){
                    $li = '<a href="'.route('serviceOffer.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }           
                if($type == 'list'){
                    if(AccessController::checkAccess("serviceOffer_delete")){
                        $li .= '<a href="'.route('serviceOffer.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("serviceOffer_restore")){
                        $li .= '<a href="'.route('serviceOffer.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    } 
                }
                return $li;
            })
            ->editColumn("image", function($row){
                return "<img src=". asset($row->image ?? "image/not-found.png") ." height=\"50\">";
            })
            ->editColumn("description", function($row){ return wordwrap($row->description, 60, "<br>"); })
            ->editColumn("position", function($row){ return wordwrap($row->position, 60, "<br>"); })
            ->editColumn("person_range", function($row){ return $row->min_range . ' - '. $row->max_range .' Person';})
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status', 'image', "description"])
            ->make(true);
    }

    
}

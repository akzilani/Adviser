<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\SocialMedia;
use App\System;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SocialMediaController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'icon', "publication_status",'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'icon', "publication_status", 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new SocialMedia();
    }

    /**
     * Show page List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "Social Media Table Show");
        $params = [
            'nav'               => 'social_media',
            'subNav'            => 'social_media.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("social_media_create") ? route('social_media.create') : false,
            'pageTitle'         => 'Social Media List',
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
            "form_url"  => route('social_media.create'),
        ]; 
        //$this->saveActivity($request, "Create Social Media Page Open");
        return view('backEnd.social_media.create', $params)->render();
    }

    /**
     * Store page Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name'      => ['required','string','min:2'],
                'icon'      => ['required','string', "min:4"],
                'link'      => ['required','string', "min:2"],
                "publication_status"    => ['required', "boolean"]
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'Social media added successfully';
                $this->saveActivity($request, "Add New Social Media");
            }else{
                $message = 'Social media updated successfully';
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Social Media Data", $data);
            }

            $data->name = $request->name;
            $data->icon = $request->icon;            
            $data->link = $request->link;            
            $data->publication_status = $request->publication_status;            
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
            "form_url"  => route('social_media.create'),
            "data"      => $this->getModel()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit Social Media Page Open");
        return view('backEnd.social_media.create', $params)->render();
    }

    /**
     * View page Message
     */
    public function view(Request $request){
        $params = [
            "data"      => $this->getModel()->find($request->id)
        ];
        return view('backEnd.social_media.view', $params)->render();
    }


    /**
     * Make the selected page   As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Social Media");
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
            $this->success('Social media restored successfully');
            $this->saveActivity($request, "Restore Social Media");
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
            'subNav'            => 'social_media.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'page Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.social_media.table', $params);
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
            ->editColumn("icon", function($row){ return "<a href='".$row->link."' target=\"_blank\" >$row->icon</a>"; })
            ->addColumn('action', function($row) use($type){                
                $li = "";
                if(AccessController::checkAccess("social_media_update")){
                    $li .= '<a href="'.route('social_media.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if($type == 'list'){
                    if(AccessController::checkAccess("social_media_delete")){
                        $li .= '<a href="'.route('social_media.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }                    
                }else{
                    if(AccessController::checkAccess("social_media_restore")){
                        $li .= '<a href="'.route('social_media.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                }
                return $li;
            })            
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status', "icon" ])
            ->make(true);
    }

    
}

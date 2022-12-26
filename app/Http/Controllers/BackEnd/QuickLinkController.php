<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\QuickLinks;
use App\System;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class QuickLinkController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'image', 'title', 'description', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'image', 'title', 'description', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new QuickLinks();
    }

    /**
     * Show Quick link  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "Quicklink Table Show");
        $params = [
            'nav'               => 'quick_link',
            'subNav'            => 'quick_link.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("quick_link_create") ? route('quick_link.create') : false,
            'pageTitle'         => 'Quick Link List',
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
            "title"     => "Create Quick Link",
            "form_url"  => route('quick_link.create'),
        ]; 
        //$this->saveActivity($request, "Add Quicklink Page Open");
        return view('backEnd.quickLinks.create', $params)->render();
    }

    /**
     * Store blog Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'title'         => ['required','string','min:2', 'max:191'],
                'description'   => ['required','string','min:2', 'max:4000'],
                'publication_status' => ['required','numeric']
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();                    
                }
                $message = 'Quick Link\'s added successfully';
                $data = $this->getModel();
                $data->slug = Str::slug($request->title .'-'. Str::random(3));
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Add new quick link ");
            }else{
                $message = 'Quick Link\'s updated successfully';
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update quick link ", $data);
            }

            $data->title = $request->title;
            $data->description = $request->description;
            $data->meta_description = $request->meta_description;
            $data->meta_tag = $request->meta_tag;
            $data->publication_status = $request->publication_status;
            /*$data->image = $this->uploadImage($request, 'image', $this->others_dir, 400, null, $data->image);*/
            $data->image = $this->uploadImage($request, "image", $this->others_dir, "", "", $data->image);
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit blog Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Quick Link  ",
            "form_url"  => route('quick_link.create'),
            "data"      => $this->getModel()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit  Quicklink Page Open");
        return view('backEnd.quickLinks.create', $params)->render();
    }

    /**
     * View quick_link Message
     */
    public function view(Request $request){
        $params = [
            "data"      => $this->getModel()->find($request->id)
        ];
        return view('backEnd.quickLinks.view', $params)->render();
    }


    /**
     * Get quick_link   DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('id', 'ASC')->get();
        }else{
            $data = $this->getModel()->orderBy('id', 'ASC')->get();
        }
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('description', function($row){ return wordwrap($row->description, 120, '<br>'); })
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('quick_link.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Message" > <span class="fa fa-eye"></span> </a> ';
                if(AccessController::checkAccess("quick_link_update")){
                    $li .= '<a href="'.route('quick_link.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }                
                if($type == 'list' && AccessController::checkAccess("quick_link_delete") ){
                    $li .= '<a href="'.route('quick_link.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }
                return $li;
            })
            ->editColumn('image', function($row){
                return '<img src="'.asset($row->image).'" style="height:60px;">';
            })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status' ,'description', 'image'])
            ->make(true);
    }

    public function archive(Request $request){
        $data = $this->getModel()->where('id', $request->id)->first();
        $this->RemoveFile($data->image);
        $data->delete();
        $this->success("Deleted successfully");
        $this->saveActivity($request, "Deleted quick link ");
        return $this->output();
    }
}

<?php

namespace App\Http\Controllers\BackEnd;

use App\page;
use App\Http\Controllers\Controller;
use App\Pages;
use App\System;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'page_name', 'cover_image', 'heading', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'page_name', 'cover_image', 'heading_text', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Available Page List
     * @return Page Name list
     */
    protected function getPageList(){
        return [
            "home_page"         => "Home Page",
            "contact_page"      => "Contact Page",
            "campain_page"      => "Campain Page",
            "about_page"        => "About Page",
            "terms_page"        => "Terms and Conditions Page",
            "privacy_page"        => "Privacy Policy Page",
            "blogs_page"        => "Blogs Page",
            "tips_page"        => "Tips and Guides Page",
            
        ];
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Pages();
    }

    /**
     * Show page List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "Page Table Show");
        $params = [
            'nav'               => 'page',
            'subNav'            => 'page.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("page_create") ? route('page.create') : false,
            'pageTitle'         => 'page List',
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
            "form_url"  => route('page.create'),
            "pages"  => $this->getPageList(),
        ]; 
        //$this->saveActivity($request, "Create Page Open");
        return view('backEnd.page.create', $params)->render();
    }

    /**
     * Store page Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'page_name'     => ['required','string','min:4'],
                'heading_text'  => ['required','string'],
                'page_content'  => ['nullable','string'],
                'cover_image'   => ['nullable','image', "mimes:jpg,png"],
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = 'Page information added successfully';
                $this->saveActivity($request, "Add new Page");
            }else{
                $message = 'Page information updated successfully';
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Page Data", $data);
            }

            $data->page_name = $request->page_name;
            $data->heading_text = $request->heading_text;
            $data->page_content = $request->page_content;
            $data->cover_image = $this->uploadImage($request, "cover_image", $this->others_dir, "", "", $data->cover_image);
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
            "form_url"  => route('page.create'),
            "data"      => $this->getModel()->find($request->id),
            "pages"  => $this->getPageList(),
        ];
        //$this->saveActivity($request, "Edit Page Open");
        return view('backEnd.page.create', $params)->render();
    }

    /**
     * View page Message
     */
    public function view(Request $request){
        $params = [
            "data"      => $this->getModel()->withTrashed()->find($request->id)
        ];
        return view('backEnd.page.view', $params)->render();
    }


    /**
     * Make the selected page   As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Page");
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
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Page restored successfully');
            $this->saveActivity($request, "Restore Page");
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
            'subNav'            => 'page.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'page Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.page.table', $params);
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
            ->editColumn("page_name", function($row){ return ucwords(str_replace("_", " ", $row->page_name)); })
            ->editColumn('cover_image', function($row){ return "<img src='".asset($row->cover_image)."' style=\"width:70px\">"; })
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('page.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Message" > <span class="fa fa-eye"></span> </a> ';
                if(AccessController::checkAccess("page_update")){
                    $li .= '<a href="'.route('page.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if($type == 'list'){
                    if(AccessController::checkAccess("page_delete")){
                        $li .= '<a href="'.route('page.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }                    
                }else{
                    if(AccessController::checkAccess("page_restore")){
                        $li .= '<a href="'.route('page.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                }
                return $li;
            })            
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'cover_image', "heading_text" ])
            ->make(true);
    }
}

<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\TipsAndGuides;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class TipsGuidesController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'image', 'title', 'description', 'type', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'image', 'title', 'description', 'type', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new TipsAndGuides();
    }

    /**
     * Show Tips & Guides List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "Tips & Guides Table Page Show");
        $params = [
            'nav'               => 'tips_guides',
            'subNav'            => 'tips_guides.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess('tips_guides_create') ? route('tips_guides.create') : null,
            'pageTitle'         => 'Tips & Guides',
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
            "title"     => "Tips & Guides",
            "form_url"  => route('tips_guides.create'),
        ]; 
        //$this->saveActivity($request, "Add New Tips & Guides Page Open");
        return view('backEnd.tips-guides.create', $params)->render();
    }

    /**
     * Store Tips & Guides Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'title'         => ['required','string','min:2', 'max:191'],
                'description'   => ['required','string','min:2', 'max:4000'],
                'type'          => ['required', 'string','min:2', 'max:25'],
                'publication_status' => ['required','numeric']
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $message = 'Tips & guides information added successfully';
                $data = $this->getModel();
                $data->slug = Str::slug($request->title .'-'. Str::random(3));
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Add New Tips & Guides");
            }else{
                $message = 'Tips & guides information updated successfully';
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Tips & Guides");
            }

            $data->title = $request->title;
            $data->description = $request->description;
            $data->meta_description = $request->meta_description;
            $data->meta_tag = $request->meta_tag;
            $data->type = $request->type;
            $data->publication_status = $request->publication_status;
            $data->image = $this->uploadImage($request, 'image', $this->others_dir, 400, null, $data->image);
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Tips & Guides Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Tips & Guides  ",
            "form_url"  => route('tips_guides.create'),
            "data"      => $this->getModel()->find($request->id),
        ];
        //$this->saveActivity($request, "Edit Tips & Guides Page Open");
        return view('backEnd.tips-guides.create', $params)->render();
    }

    /**
     * View Tips & Guides Message
     */
    public function view(Request $request){
        $params = [
            "data"      => $this->getModel()->find($request->id)
        ];
        return view('backEnd.tips-guides.view', $params)->render();
    }

    /**
     * Delete Tips & Guides
     */
    public function archive(Request $request){
        $data = $this->getModel()->find($request->id);
        $this->RemoveFile($data->image);
        $data->delete();
        $this->success("Deleted successfully");
        $this->saveActivity($request, "Delete tips & guides ");
        return $this->output();
    }


    /**
     * Get Tips & Guides   DataTable
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
            ->editColumn('description', function($row){ return wordwrap($row->description, 70, '<br>'); })
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('tips_guides.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Message" > <span class="fa fa-eye"></span> </a> ';
                if(AccessController::checkAccess("tips_guides_update")){
                    $li .= '<a href="'.route('tips_guides.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                } 
                
                if($type == 'list'){
                    if(AccessController::checkAccess("tips_guides_delete")){
                        $li .= '<a href="'.route('tips_guides.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("tips_guides_restore")){
                        $li .= '<a href="'.route('tips_guides.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    } 
                }
                return $li;
            })
            ->editColumn('image', function($row){
                return '<img src="'.asset($row->image).'" style="height:60px;">';
            })
            ->editColumn('type', function($row){ return ucwords(str_replace('_',' ', $row->type)); })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status' ,'description', 'image'])
            ->make(true);
    }
}

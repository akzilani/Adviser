<?php

namespace App\Http\Controllers\BackEnd;

use App\AuthorList;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class AuthorListController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'publication_status',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new AuthorList();
    }

    /**
     * Show AuthorList List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }

        //$this->saveActivity($request, "View Advisor type");
        $params = [
            'nav'               => 'authorList',
            'subNav'            => 'authorList.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("authorList_create") ? route('authorList.create') : false,
            'pageTitle'         => 'Author List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New AuthorList
     */
    public function create(){
        $params = [
            "title"     => "Create Author List",
            "form_url"  => route('authorList.create'),
        ]; 
        return view('backEnd.authorList.create', $params)->render();
    }

    /**
     * Store AuthorList Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name'              => ['required','string','min:2', "max:191" ],
                'publication_status'=> ['required','numeric']
            ]);
            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $message = 'Author list information added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
            }else{
                $message = 'Author list information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
            }

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
     * Edit AuthorList Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Author List",
            "form_url"  => route('authorList.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
        ];
        return view('backEnd.authorList.create', $params)->render();
    }

    /**
     * Make the selected AuthorList As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected AuthorList As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Author list restored successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive AuthorList List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        $params = [
            'nav'               => 'authorList' ,
            'subNav'            => 'authorList.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Author List Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.authorList.table', $params);
    }

    /**
     * Get AuthorList DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('id', 'asc')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('id', 'asc')->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('authorList.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    if(AccessController::checkAccess("authorList_delete")){
                        $li .= '<a href="'.route('authorList.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }                    
                }else{
                    $li .= '<a href="'.route('authorList.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
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
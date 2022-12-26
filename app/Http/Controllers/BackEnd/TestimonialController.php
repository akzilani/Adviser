<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\System;
use App\Testimonial;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'date', 'advisor', 'name', 'location', 'description', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'date', 'advisor', 'name', 'location', 'description', 'publication_status', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Testimonial();
    }

    /**
     * Show Testimonial List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "View Testimonial Table");
        $params = [
            'nav'               => 'testimonial',
            'subNav'            => 'testimonial.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess('testimonial_create') ? route('testimonial.create') : false,
            'pageTitle'         => 'Testimonial List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Testimonial",
            "form_url"  => route('testimonial.create'),
            "advisors"  => User::all(),
        ]; 
       // $this->saveActivity($request, "Create Testimonial Page Open");
        return view('backEnd.testimonial.create', $params)->render();
    }

    /**
     * Store Testimonial Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'advisor_id'    => ['required','numeric','min:1'],
                'name'          => ['required','string','min:2', 'max:100'],
                'location'      => ['nullable','string','min:2', 'max:100'],
                'description'   => ['required','string','min:2', 'max:1000'],
                'publication_status' => ['required','numeric']
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $message = 'Testimonial information added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Add New Testimonial");
            }else{
                $message = 'Testimonial information updated successfully';
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Testimonial", $data);
            }

            $data->advisor_id = $request->advisor_id;
            $data->name = $request->name;
            $data->location = $request->location;
            $data->publication_status = $request->publication_status;
            $data->description = $request->description;
            $data->save();
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Testimonial Info
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Testimonial",
            "form_url"  => route('testimonial.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
            "advisors"  => User::all(),
        ];
        //$this->saveActivity($request, "Edit Testimonial Page Open");
        return view('backEnd.testimonial.create', $params)->render();
    }


    /**
     * Make the selected Testimonial   As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Deleted Testimonial");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Testimonial   As Active from Archive
     */
    public function restore(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Testimonial restored successfully');
            $this->saveActivity($request, "Restore Testimonial");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Testimonial   List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }
        
        //$this->saveActivity($request, "View Deleted Testimonial Table");
        $params = [
            'nav'               => 'subscription' ,
            'subNav'            => 'testimonial.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Testimonial Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.testimonial.table', $params);
    }

    /**
     * Get Testimonial   DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        $data = $this->getModel()->join('advisors', 'advisors.id', '=', 'testimonials.advisor_id')->where('advisors.deleted_at', null);
        if( $type == "list" ){
            $data = $data->orderBy('created_at', 'DESC')->orderBy('id', 'ASC')->select('testimonials.*')->get();
        }else{
            $data = $data->orderBy('created_at', 'DESC')->onlyTrashed()->orderBy('id', 'ASC')->select('testimonials.*')->get();
        }
        $system = System::first();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('advisor', function($row){ return ($row->advisor->first_name ?? 'N/A'). ' ' .($row->advisor->last_name ?? ''); })
            ->addColumn('date', function($row)use($system){ return Carbon::parse($row->created_at)->format($system->date_format); })
            ->addColumn('action', function($row) use($type){   
                $li = "";
                if(AccessController::checkAccess("testimonial_update")){
                    $li = '<a href="'.route('testimonial.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }             
                
                if($type == 'list'){
                    if(AccessController::checkAccess("testimonial_delete")){
                        $li .= '<a href="'.route('testimonial.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    } 
                }else{
                    if(AccessController::checkAccess("testimonial_restore")){
                        $li .= '<a href="'.route('testimonial.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    } 
                }
                return $li;
            })
            ->editColumn('description', function($row){ return wordwrap($row->description ,"72", "<br>"); })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status', 'description' ])
            ->make(true);
    }

    
}

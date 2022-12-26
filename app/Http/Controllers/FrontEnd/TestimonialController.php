<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\System;
use App\Testimonial;
use App\TremsAndCondition;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'date', 'name', 'location', 'description', 'publication_status', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'date', 'name', 'location', 'description', 'publication_status', 'action'];
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
        
        //$this->saveActivity($request, "Advisor Testimonial Table Show");
        $params = [
            'nav'               => 'testimonial',
            'subNav'            => 'testimonial.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('advisor.testimonial.create'),
            'pageTitle'         => 'Testimonial List',
            'tableStyleClass'   => 'bg-success'

        ];
        return view('frontEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Testimonial",
            "form_url"  => route('advisor.testimonial.create'),
            "terma_and_condition"   => TremsAndCondition::where("type", "Testimonial Terms & Conditions")->first(),
            
        ]; 
        $this->saveActivity($request, "Create Advisor Testimonial Page Open");
        return view('frontEnd.advisor.testimonial.create', $params)->render();
    }

    /**
     * Store Testimonial Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
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
                $message = "Testimonial information added successfully";
                $data = $this->getModel();
                $this->saveActivity($request, "Add New Advisor Testimonial");
            }else{
                $message = "Testimonial information updated successfully";
                $data = $this->getModel()->withTrashed()->find($request->id);
                $this->saveActivity($request, "Update Advisor Testimonial", $data);
            }

            $data->advisor_id = Auth::user()->id;
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
            "form_url"  => route('advisor.testimonial.create'),
            "data"      => $this->getModel()->withTrashed()->find($request->id),
            "terma_and_condition"   => TremsAndCondition::where("type", "Testimonial Terms & Conditions")->first(),
        ];
        //$this->saveActivity($request, "Edit Advisor Testimonial Page Open");
        return view('frontEnd.advisor.testimonial.create', $params)->render();
    }


    /**
     * Make the selected Testimonial   As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Advisor Testimonial");
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
            $this->saveActivity($request, "Restore Advisor Testimonial");
            $this->success('Testimonial restored successfully');
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
        
        
        $params = [
            'nav'               => 'subscription' ,
            'subNav'            => 'advisor.testimonial.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Testimonial   Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('frontEnd.table', $params);
    }

    /**
     * Get Testimonial   DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->where('advisor_id', Auth::user()->id)->orderBy('created_at', 'DESC')->orderBy('id', 'ASC')->get();
        }else{
            $data = $this->getModel()->where('advisor_id', Auth::user()->id)->onlyTrashed()->orderBy('created_at', 'DESC')->orderBy('id', 'ASC')->get();
        }
        $system = System::first();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('description', function($row){ return wordwrap($row->description ,"72", "<br>"); })
            ->addColumn('date', function($row)use($system){ return Carbon::parse($row->created_at)->format($system->date_format); })
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('advisor.testimonial.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    $li .= '<a href="'.route('advisor.testimonial.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }else{
                    $li .= '<a href="'.route('advisor.testimonial.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                }
                return $li;
            })
            
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->rawColumns(['action', 'publication_status', "description" ])
            ->make(true);
    }

    
}

<?php

namespace App\Http\Controllers\FrontEnd;

use App\AdvisorCompliance;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ComplianceController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'compliance', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'compliance', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new AdvisorCompliance();
    }

    /**
     * Show Testimonial List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable($request);
        }
        
        $this->saveActivity($request, "Advisor Compliance Table Show"); 
        $params = [
            'nav'               => 'advisor',
            'subNav'            => 'advisor.compliance',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => route('advisor.compliance.create'),
            'pageTitle'         => 'Compliance List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-lg",
        ];
        return view('frontEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Compliance",
            "form_url"  => route('advisor.compliance.create'),
        ]; 
        $this->saveActivity($request, "Advisor Compliance Create Page Open"); 
        return view('frontEnd.advisor.compliance.create', $params)->render();
    }

    /**
     * Store Testimonial Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'compliance' => ['required', 'string','min:2', 'max:3000'],
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }                
                $data = $this->getModel();
                $this->saveActivity($request, "Add New Advisor Compliance");
            }else{
                $data = $this->getModel()->find($request->id);
                $this->saveActivity($request, "Update Advisor Compliance", $data);
            }

            $data->advisor_id = $request->user()->id;
            $data->compliance = $request->compliance;
            $data->save();
            $this->success('Compliance added/updated successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Create Compliance",
            "form_url"  => route('advisor.compliance.create'),
            "data"      => $this->getModel()->find($request->id),
        ]; 
        //$this->saveActivity($request, "Edit Advisor Compliance Page Open");
        return view('frontEnd.advisor.compliance.create', $params)->render();
    }

    /**
     * Delete
     */
    public function delete(Request $request){
        $this->getModel()->where('id', $request->id)->delete();
        $this->success("Deleted successfully");
        $this->saveActivity($request, "Delete Advisor Compliance");
        return $this->output();
    }

    /**
     * Get Complance   DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($request){
        $data = $this->getModel()->where('advisor_id', $request->user()->id)->orderBy('id', 'ASC')->get();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('compliance', function($row){ return wordwrap($row->compliance ,"120", "<br>"); })
            ->addColumn('action', function($row){                
                $li = '<a href="'.route('advisor.compliance.edit', [$row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                $li .= '<a href="'.route('advisor.compliance.delete', [$row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                return $li;
            })
            
            // ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->rawColumns(['action', 'compliance'])
            ->make(true);
    }
}

<?php

namespace App\Http\Controllers\BackEnd;

use App\ContactUs;
use App\Http\Controllers\Controller;
use App\System;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EnquiresController extends Controller
{
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'date', 'service_offer', 'name', 'email', 'company_name', 'phone', 'post_code', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'date', 'service_offer', 'name', 'email', 'company_name', 'phone_number', 'post_code', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new ContactUs();
    }

    /**
     * Show blog List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "Enquire Table Page Show");
        $params = [
            'nav'               => 'enquires',
            'subNav'            => 'enquires.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => false,
            'pageTitle'         => 'Enquires/Contact Us Message List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-lg"
        ];
        return view('backEnd.table', $params);
    }

    /**
     * View Enquires Message
     */
    public function view(Request $request){
        $data = $this->getModel()->find($request->id);
        if(!$data->is_seen){
            $data->is_seen = true;
            $data->save();
        }        
        $params = [
            "data"      => $data,
        ];
        //$this->saveActivity($request, "View Enquire Data", $data);
        return view('backEnd.enquires.view', $params)->render();
    }

    /**
     * Delete Message
     */
    public function delete(Request $request){
        try{
            $this->getModel()->where('id', $request->id)->delete();
            $this->success("Deleted successfully");
            $this->saveActivity($request, "Deleted enquiry ");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Get blog   DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = $this->getModel()->orderBy('created_at', 'ASC')->orderBy('id', 'ASC')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('created_at', 'ASC')->orderBy('id', 'ASC')->get();
        }
        $system = System::first();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('date', function($row)use($system){ return Carbon::parse($row->created_at)->format($system->date_format); })
            ->addColumn('name', function($row){ return $row->first_name . ' ' . $row->last_name; })
            ->addColumn('service_offer', function($row){ return $row->service_interest ?? 'N/A'; })
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('enquires.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Message" > <span class="fa fa-eye"></span> View</a> ';
                if($type == 'list'){
                    if(AccessController::checkAccess("enquires_delete")){
                        $li .= '<a href="'.route('enquires.delete',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }                    
                }
                return $li;
            })       
            ->rawColumns(['action'])
            ->make(true);
    }
}

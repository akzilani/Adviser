<?php

namespace App\Http\Controllers\FrontEnd;

use App\Communication;
use App\Http\Controllers\Controller;
use App\System;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CommunicationController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'date', 'subject','time', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'date', 'subject','time', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return Communication::where('advisor_id', Auth::user()->id);
    }

    /**
     * Show Communication List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "View Communication Table");
        $params = [
            'nav'               => 'communication',
            'subNav'            => 'communication.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => false,
            'pageTitle'         => 'Communication List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-lg"
        ];
        return view('frontEnd.table', $params);
    }


    

    /**
     * View Communication Message
     */
    public function view(Request $request){
        $params = [
            "data"      => $this->getModel()->withTrashed()->find($request->id)
        ];
        //$this->saveActivity($request, "View Communication Data");
        return view('frontEnd.advisor.communication.view', $params)->render();
    }


    /**
     * Make the selected Communication   As Archive
     */
    public function archive(Request $request){
        try{
            
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Communication Data");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected Communication   As Active from Archive
     */
    public function restore(Request $request){
        try{
            $this->saveActivity($request, "Restore Communication Data");
            $data = $this->getModel()->withTrashed()->find($request->id);
            $data->restore();
            $this->success('Communication restored successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Communication   List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }        
        
        $params = [
            'nav'               => 'subscription' ,
            'subNav'            => 'communication.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Communication Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('frontEnd.table', $params);
    }

    /**
     * Get Communication   DataTable
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
            ->addColumn('action', function($row) use($type){                
                $li = '<a href="'.route('communication.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Message" > <span class="fa fa-eye"></span> </a> ';
                return $li;
            })
            ->addColumn('date', function($row)use($system){ return Carbon::parse($row->created_at)->format($system->date_format); })
            ->addColumn('time', function($row)use($system){ return Carbon::parse($row->created_at)->format('H:i:s'); })
            ->editColumn("publication_status", function($row){ return $this->getStatus($row->publication_status); })
            ->rawColumns(['action', 'publication_status' ])
            ->make(true);
    }

    
}

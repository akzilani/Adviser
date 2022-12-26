<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\System;
use App\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VisitorController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'date', 'ip', 'browser', 'device', 'os', 'county', 'city', 'page_visit'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'date', 'ip', 'browser', 'device', 'os', 'country_code', 'city', 'visit_count'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Visitor;
    }


    /**
     * Show Visitor List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        $params = [
            'nav'               => 'dashboard',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Website Visitor List',
            'tableStyleClass'   => 'bg-success',
        ];
        return view('backEnd.visitortable', $params);
    }

    /**
     * Get Admin DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable(){
        $data = $this->getModel()->orderBy('id', 'DESC')->get();
        $system = System::first();
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('date', function($row) use($system){ return Carbon::parse($row->date)->format($system->date_format); })
            ->make(true);
    }

    
}

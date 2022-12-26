<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\System;
use App\TremsAndCondition;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TermsAndConditionController extends Controller
{
    
    /**
     * Get Page All Type
     */
    public static function getPageType(){
        return [
            "Sign up"           => "Sign up", 
            "Terms & Conditions"=> "Terms & Conditions", 
            "Privacy Policy"    => "Privacy Policy", 
            "Cookies"           => "Cookies",
            "Disclaimer"        => "Disclaimer", 
            "Advisor Profile Page" => "Advisor Profile Page Text",
            "Advisor List Page Blue Box Header"    => 'Advisor List Page Blue Box Header',
            "Advisor List Page Blue Box Paragraph" => 'Advisor List Page Blue Box Paragraph',
            "Advisor List Page"    => 'Advisor List Page Popup',
            "Popup Page"            => "Popup Page",
            "Footer"                => "Footer",
            "Footer_CopyRight"                => "Footer CopyRight",
            "Campaign Page Footer"  => "Campaign Page Footer",
            "Campaign Page Bidding Platform"  => "Campaign Page Bidding Platform",
            "Campaign Page Powerful Tools"  => "Campaign Page Powerful Tools",
            "Campaign Page Auction Room "  => "Campaign Page Auction Room",
            "Campaign Page Match Rating"  => "Campaign Page Match Rating",
            "Campaign Page Build Your Profile "  => "Campaign Page Build Your Profile",
            "Campaign Page How Much Cost "  => "Campaign Page How Much Cost",
            "Campaign Page Footer CopyRight "  => "Campaign Page Footer CopyRight",
            "Questions & Answers Page Footer" => "Questions & Answers Page Footer",
            "About Us About Regulated Advice"         => "About Us About Regulated Advice",
            "About Us Unbiased Reviews"         => "About Us Unbiased Reviews",
            "About Us Match Rating"         => "About Us Match Rating",
            "About us How Does Regulated Make Money"         => "About us How Does Regulated Make Money",
            "Testimonial Terms & Conditions"         => "Testimonial Terms & Conditions",
            "Auction Terms & Conditions"         => "Auction Terms & Conditions",
        ];
    }

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#','page_type', 'content',  'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index','type', 'trems_and_condition', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new TremsAndCondition();
    }

    

    /**
     * Show blog List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        //$this->saveActivity($request, "Dynamic Page Table Show");
        $params = [
            'nav'               => 'terms_&_condition',
            'subNav'            => 'terms_&_condition.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),            
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("terms_&_condition_create") ? route('terms_&_condition.create') : false,
            'pageTitle'         => 'Dynamic Page Content List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-xl"
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create terms_&_condition
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Dynamic Page Content",
            "page_type"         => self::getPageType(),
            "form_url"  => route('terms_&_condition.create'),            
        ];
        //$this->saveActivity($request, "Create Dynamic Page Open");
        return view('backEnd.termsAndCondition.create', $params)->render();
    }

    /**
     * Create terms_&_condition
     */
    public function edit(Request $request){
        $params = [
            "title"     => "Edit Dynamic Page Content",
            "page_type" => self::getPageType(),
            "form_url"  => route('terms_&_condition.create'), 
            "data"      => TremsAndCondition::find($request->id),           
        ];
        $this->saveActivity($request, "Edit Dynamic Page Open");
        return view('backEnd.termsAndCondition.create', $params)->render();
    }

    /**
     * Save terms_&_condition Information
     */
    public function store(Request $request){
        try{ 
            DB::beginTransaction();           
            if( $request->id == 0 ){
                $message = 'Dynamic Page Content added successfully';
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Add New Dynamic Page");
            }else{
                $message = 'Dynamic Page Content updated successfully';
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Update Dynamic Page Data", $data);
            }
            $data->trems_and_condition = $request->trems_and_condition;
            $data->type = $request->type;
            $data->save();
            if($data->type == "Auction Terms & Conditions" || $data->type ==  'Sign up'){
                User::where("id", ">", 0)->update(["accept_auction_condition" => false]);
            }
            DB::commit();
            $this->success($message);
        }catch(Exception $e){
            DB::beginTransaction();
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * View Page Content
     */
    public function view(Request $request){
        $params = [
            "data" => TremsAndCondition::where('id', $request->id)->first(),
        ];
        return view('backEnd.termsAndCondition.view', $params)->render();
    }

    public function archive(Request $request){
        try{
            TremsAndCondition::where('id', $request->id)->delete();
            $this->success("Deleted successfully");
            $this->saveActivity($request, "Delete Dynamic Page Data");
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
            $data = $this->getModel()->orderBy('type', 'ASC')->get();
        }else{
            $data = $this->getModel()->onlyTrashed()->orderBy('type', 'ASC')->get();
        }
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn('trems_and_condition', function($row){ return  mb_substr($row->trems_and_condition, 0, 100); })
            ->editColumn('type', function($row){ return $row->type; })
            ->addColumn('action', function($row) use($type){ 
                $li = '<a href="'.route('terms_&_condition.view',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View" > <span class="fa fa-eye"></span> </a>';
                if(AccessController::checkAccess("terms_&_condition_update")){
                    $li .= '<a href="'.route('terms_&_condition.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                
                if($type == 'list'){
                    if(AccessController::checkAccess("terms_&_condition_delete")){
                        $li .= '<a href="'.route('terms_&_condition.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }
                return $li;
            })            
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', 'publication_status' ,'trems_and_condition' ])
            ->make(true);
    }
}

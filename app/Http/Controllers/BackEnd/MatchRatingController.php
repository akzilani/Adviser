<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Components\Classes\MatchRating as ClassesMatchRating;
use App\Http\Controllers\Controller;
use App\MatchRating;
use App\ServiceOffer;
use App\SubscriptionPlan;
use App\System;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class MatchRatingController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'date', 'type', 'area_of_advice', 'plan', 'star', 'no_of_question', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'date', 'type', 'area_of_advice', 'plan', 'star', 'no_of_question', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new MatchRating();
    }

    /**
     * Show MatchRating List without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        
        $params = [
            'nav'               => 'match_rating',
            'subNav'            => 'match_rating.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            "create"            => AccessController::checkAccess("match_rating_create") ? route('match_rating.create') : false,
            'pageTitle'         => 'Match Rating ',
            'tableStyleClass'   => 'bg-success',
            'modalSizeClass'    => "modal-md", 
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [
            "title"     => "Create Match Rating ",
            "form_url"  => route('match_rating.create'),
            'service_offers' => ServiceOffer::where('publication_status', 1)->get(),
            "plans"=> SubscriptionPlan::where('publication_status', 1)->get(),
        ];
        //$this->saveActivity($request, "Create Match Rating Page Open");
        return view('backEnd.matchRating.create', $params)->render();
    }

    /**
     * Edit auction Info
     */
    public function edit(Request $request){
        $match_rating = $this->getModel()->find($request->id);
        $params = [
            "title"     => "Edit Match Rating",
            "form_url"  => route('match_rating.create'),
            'service_offers' => ServiceOffer::where('publication_status', 1)->get(),
            "plans" => SubscriptionPlan::where('publication_status', 1)->get(),
            "data"  => $match_rating
        ];
       // $this->saveActivity($request, "Edit Match Rating Page Open");
        return view('backEnd.matchRating.create', $params)->render();
    }

    /**
     * Save / Update auction Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                "rating_type"   => ["required", "string", "min:7"],
                "no_of_question"=> ["required", "numeric", "min:1"],
                "subscription_plan_id" => ["required", "numeric", "min:1"],
                "no_of_star"    => ["required", "numeric", "min:1"]
            ]);
            
            if( $validator->fails()){
                $this->message = $this->getValidationError($validator);
                $this->modal = false;
                return $this->output();
            }
        
            if( $request->id == 0 ){
                if( !AccessController::checkAccess('auction_create') ){
                    return $this->accessDenie();
                }   
                $message = 'Match rating added successfully';             
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $this->saveActivity($request, "Create New Match Rating");
            }else{
                if( !AccessController::checkAccess('auction_update') ){
                    return $this->accessDenie();
                }
                $data = $this->getModel()->find($request->id);
                $data->updated_by = $request->user()->id;
                $message = 'Match rating updated successfully';
                $this->saveActivity($request, "Update Match Rating", $data);
            }            
                                  
            $data->rating_type      = $request->rating_type;
            $data->subscription_plan_id= $request->subscription_plan_id;
            $data->no_of_question   = $request->no_of_question;
            $data->no_of_star       = $request->no_of_star;
            $data->service_offer_id = $request->service_offer_id ?? Null;
            $data->save();
            (new ClassesMatchRating(Null, $data->subscription_plan_id))->handel();
            // (new ClassesMatchRating())->handel();

            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected auction As Archive
     */
    public function delete(Request $request){
        try{
            $data = $this->getModel()->find($request->id);
            (new ClassesMatchRating(Null, $data->subscription_plan_id))->handel();
            $data->delete();
            $this->success('Deleted successfully');
            $this->saveActivity($request, "Delete Match Rating");
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }


    /**
     * Get auction DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable(){
        $data = $this->getModel()->get();
        $system = System::first();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->addColumn('area_of_advice', function($row){ return $row->service_offer->name ?? ""; })
            ->editColumn("type", function($row){ return ucwords($row->rating_type); })
            ->addColumn("plan", function($row){ return $row->plan->name ?? ""; })
            ->addColumn("star", function($row){ return $row->no_of_star ?? ""; })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->addColumn("date", function($row) use($system){ return Carbon::parse($row->created_at)->format($system->date_format); })
            ->addColumn('action', function($row){
                $li = "";  
                if(AccessController::checkAccess("match_rating_update")){
                    $li = '<a href="'.route('match_rating.edit', ['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if(AccessController::checkAccess("match_rating_delete")){
                    $li .= '<a href="'.route('match_rating.delete', ['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                } 
                return $li;
            })
            ->rawColumns(["action"])
            ->make(true);
    }

    public function reGenerate(){
        (new ClassesMatchRating())->handel();
        return "success";
    }

    
}

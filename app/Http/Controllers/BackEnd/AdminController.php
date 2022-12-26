<?php

namespace App\Http\Controllers\BackEnd;

use App\ActivityLog;
use App\Admin;
use App\Group;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'bio' , 'email', 'phone', 'address', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'bio' , 'email', 'phone', 'address', 'created_by', 'updated_by', 'action'];
        return $columns;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new Admin;
    }


    /**
     * Show Admin List  without Archive
     */
    public function index(Request $request){   
            
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        //$this->saveActivity($request, "Load Admin List"); 
        $params = [
            'nav'               => 'admin',
            'subNav'            => 'admin.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("admin_create") ? route('admin.create') : false,
            'pageTitle'         => 'Admin List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-xl"
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        //$this->saveActivity($request, "Admin Creation Page Open"); 
        $params = [
            "title"     => "Create Admin",
            "form_url"  => route('admin.create'),
            "groups"    => Group::all(),
        ];       
        return view('backEnd.admin.create', $params)->render();
    }

    /**
     * Store Admin Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'email'         => ['required','email', 'unique:admins'],
                'phone'         => ['nullable','numeric'],
                'name'          => ['required','string','min:2', 'max:100'],
                'bio'           => ['required','string','min:2', 'max:4000']
            ]);

            if( $request->id == 0 ){
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }                
                $data = $this->getModel();
                $data->created_by = $request->user()->id;
                $message = "Admin Created Successfully";
                $this->saveActivity($request, "Admin Created", $data); 
            }else{
                $message = "Admin information updated successfully";
                $data = $this->getModel()->withTrashed()->find($request->id);
                $data->updated_by = $request->user()->id;
                $this->saveActivity($request, "Admin Information Updated", $data); 
            }
            $data->name = $request->name;
            $data->bio  = $request->bio;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->group_id = $request->group_id;
            $data->address = $request->address;
            $data->password = !empty($request->password) ? bcrypt($request->password) : $data->password;
            $data->remember_token = empty($data->remember_token) ? Str::random(60) : $data->remember_token;
            $data->image = $this->uploadImage($request, 'image', $this->admin_profile, Null, 80, $data->image);
            $data->save();
            
            $this->success($message);
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Admin Info
     */
    public function edit(Request $request){
        $data = Admin::withTrashed()->find($request->id);
        $params = [
            "title"     => "Edit Admin",
            "form_url"  => route('admin.create'),
            "groups"    => Group::all(),
            "data"      => $data,
        ]; 
        //$this->saveActivity($request, "Admin Edit Page Open", $data); 
        return view('backEnd.admin.create', $params)->render();
    }

    /**
     * Show Admin Profile 
     */
    public function showProfile(Request $request){
        
        $data = Admin::withTrashed()->find($request->id);
        return view('backEnd.admin.profile',['data' => $data])->render();
    }

    /**
     * Make the selected admin As Archive
     */
    public function archive(Request $request){
        try{
            if(!AccessController::checkAccess("admin_delete")){
                $this->message = "Permission Missing";
                return $this->output();
            }
            $data = Admin::withTrashed()->find($request->id);
            $data->delete();
            $this->success('Deleted successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Make the selected admin As Active from Archive
     */
    public function restore(Request $request){
        try{
            if(!AccessController::checkAccess("admin_restore")){
                $this->message = "Permission Missing";
                return $this->output();
            }
            $data = Admin::withTrashed()->find($request->id);
            $data->restore();
            $this->success('Admin restored successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Show Archive Admin List
     */
    public function archiveList(Request $request){
        
        if( $request->ajax() ){
            return $this->getDataTable('archive');
        }        
        $params = [
            'nav'               => 'admin',
            'subNav'            => 'admin.archive_list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Admin Archive List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Show Activity Log
     */
    public function ActivityLog(Request $request){
        $activity_logs = ActivityLog::orderBy("id", "DESC");
        if( !empty($request->search) ){
            $activity_logs = $activity_logs->whereHas("advisor", function($qry) use($request){
                $qry->where("first_name", "like", "%" .$request->search ."%")
                ->orWhereRaw("concat(first_name, ' ', last_name) like '%$request->search%' ")
                ->orWhere("last_name", "like", "%" .$request->search ."%");
            })
            ->orWhereHas("admin", function($qry) use($request){
                $qry->where("name", "like", "%" .$request->search ."%");
            })
            ->orwhere("ip", $request->search)
            ->orwhere("activity", "like", "%" .$request->search ."%");
        }
       
        if($request->user_type == "advisor_admin"){
            $activity_logs->where("advisor_id", "!=", Null);
        }else{
            $activity_logs->where("admin_id", "!=", Null);
        }

        $activity_logs = $activity_logs->paginate(50);
        $params = [
            'nav'               => 'activity_log',
            'pageTitle'         => 'Activity Log',
            'tableStyleClass'   => 'bg-success',
            "activity_logs"     => $activity_logs,
        ];
        return view('backEnd.activity-table', $params);
    }

    /**
     * Delete Activity
     */
    protected function deleteActivity(Request $request){
        $validator = Validator::make($request->all(),[
            "ids"   => ["required","array"],
            "ids.*" => ["required", "numeric"]
        ],[
            "ids.required" => "Atleast one activity have to select."
        ]);
        if($validator->fails()){
            return back()->with("error", $this->getValidationError($validator));
        }
        ActivityLog::whereIn("id", $request->ids)->delete();
        return back()->with("success", "Deleted Successfully.");
    }

    /**
     * Get Admin DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        if( $type == "list" ){
            $data = Admin::where('is_developer', false)->orderBy('name', 'ASC')->get();
        }else{
            $data = Admin::where('is_developer', false)->onlyTrashed()->get();
        }

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; }) 
            ->editColumn('bio', function($row){ return  wordwrap($row->bio, "60", "<br>"); })
            ->addColumn('role', function($row){ return ucfirst(str_replace('_',' ', $row->user_type)); })
            ->addColumn('action', function($row) use($type){ 
                $li = '<a href="'.route('admin.profile',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-primary" title="View Details" > <span class="fa fa-eye"></span> </a> ';
                $li .= '<a href="'.route('admin.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                if($type == 'list'){
                    if(AccessController::checkAccess("admin_delete")){
                        $li .= '<a href="'.route('admin.archive',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                    }
                }else{
                    if(AccessController::checkAccess("admin_restore")){
                        $li .= '<a href="'.route('admin.restore',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger" > <i class="fas fa-redo"></i> </a> ';
                    }
                }
                return $li;
            })
            ->editColumn("created_by", function($row){ return $row->createdBy->name ?? "N/A"; })
            ->editColumn("updated_by", function($row){ return $row->updatedBy->name ?? "N/A"; })
            ->rawColumns(['action', "bio" ])
            ->make(true);
    }

    /**
     * Admin Monitoring
     */
    public function monitoringList(Request $request){
        if( $request->ajax() ){
            return $this->getMonitoringDataTable('archive');
        }
        $params = [
            'nav'               => 'admin',
            'subNav'            => 'admin.monitoring',
            'tableColumns'      => $this->getMonitoringColumns(),
            'dataTableColumns'  => $this->getMonitoringDataTableColumns(),
            'dataTableUrl'      => Null,
            'pageTitle'         => 'Admin Monitoring',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.admin.table', $params);
    }

    /**
     * Get Monitoring Table Column List
     */
    private function getMonitoringColumns(){
        $columns = ['#', 'name', 'visit_page', 'action', 'from_status', 'to_status', 'time'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getMonitoringDataTableColumns(){
        $columns = ['index', 'name', 'active_page', 'action', 'from_status', 'to_status', 'created_at'];
        return $columns;
    }

    
}

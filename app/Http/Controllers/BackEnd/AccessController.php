<?php

namespace App\Http\Controllers\BackEnd;

use App\Group;
use App\GroupAccess;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AccessController extends Controller
{
    private $accesses = [
        ["admin", "Admin", "access" => [            
            ["admin_list", "Create Table Show"],
            ["admin_create", "Create Admin"],
            ["admin_edit", "Edit Admin"],
            ["admin_delete", "Admin Delete"],
            ["admin_restore", "Admin Restore"],     
            ]],
            
            // Advisor
            ["advisor", "Advisor List", "access" => [
                ["advisor_list", "Show Advisor Table"],
                ["advisor_missing_info_list", "Show Advisor Missing Info Table"],
                ["advisor_create", "Create Advisor"],
                ["advisor_update", "Update Advisor"],
                ["advisor_delete", "Delete Advisor"],
                ["advisor_billing", "Advisor Billing Table"],
                ["advisor_update", "Advisor Billing Update"],
                ["import_advisor_list", "Import Advisor List"],
                       
                ['promotional_list', 'Show Advisor Promotional List'],
                ['promotional_create', 'Create & Update Advisor Promotional List'],
                ['promotional_delete', 'Delete Advisor Promotional List'],
                ["advisor_deleted_list", "Show Deleted Advisor Table"],
                ["advisor_restore", "Restore Deleted advisor"],
        ]],

        // Office Namager 
        ["office_manager", "Office Manager", "access" => [
            ["office_manager_list", "Show Office Manager Table"],
            ["office_manager_create", "Create Office Manager"],
            ["office_manager_update", "Update Office Manager"],
            ["office_manager_delete", "Delete Office Manager"],
            ["office_manager_restore", "Restore Office Manager"],
        ]],

        // Manage Lead 
        ["lead", "Manage Lead", "access" => [
            ["lead_list", "Show Lead Table"],
            ["lead_archive_list", "Show Archive Lead Table"],
            ["lead_create", "Create Lead"],
            ["lead_update", "Update Lead"],
            ["lead_delete", "Delete Lead"],
            ["lead_restore", "Restore Lead"],
            ["lead_permanent_delete", "Permanent Delete Lead"],
            ["lead_assign_auction", "Assign Lead into Auction"],
        ]],

        // Auction Lead 
        ["auction", "Auction Lead", "access" => [
            ["auction_list", "Show Auction Lead Table"],
            ["auction_archive_list", "Show Auction Lead Table"],
            ["auction_create", "Create Auction Lead"],
            ["auction_update", "Update Auction Lead"],
            ["auction_archive", "Archive Auction Lead"],
            ["auction_delete", "Delete Auction Lead"],
            ["auction_restore", "Delete Auction Lead"],
        ]],

        // Match Rating 
        ["match_rating", "Match Rating", "access" => [
            ["match_rating_list", "Show Match Rating Table"],
            ["match_rating_create", "Create Match Rating"],
            ["match_rating_update", "Update Match Rating"],
            ["match_rating_delete", "Delete Match Rating"],
        ]],
        
        // Advisor Question 
        ["advisorQuestion", "Advisor Question", "access" => [
            ["advisorQuestion_list", "Show Advisor Question Table"],
            ["advisorQuestion_create", "Create Advisor Question"],
            ["advisorQuestion_update", "Update Advisor Question"],
            ["advisorQuestion_delete", "Delete Advisor Question"],
        ]],

        // Advisor Interview Question 
        ["interview_question", "Advisor Interview Question", "access" => [
            ["interview_question_list", "Show Advisor Interview Question Table"],
            ["interview_question_create", "Create Advisor Interview Question"],
            ["interview_question_update", "Update Advisor Interview Question"],
            ["interview_question_delete", "Delete Advisor Interview Question"],
            ["interview_question_answer_list", "Advisor Interview Question Answer"],
            ["interview_question_answer_update", "Update Advisor Interview Question Answer"],
            ["interview_question_answer_delete", "Delete Advisor Interview Question Answer"],
        ]],

        // Advisor Type 
        ["advisorType", "Advisor Type", "access" => [
            ["advisorType_list", "Show Advisor Type Table"],
            ["advisorType_create", "Create Advisor Type"],
            ["advisorType_update", "Update Advisor Type"],
            ["advisorType_delete", "Delete Advisor Type"],
        ]],

        //Profession 
        ["profession", "Profession", "access" => [
            ["profession_list", "Show Profession Table"],
            ["profession_create", "Create Profession"],
            ["profession_update", "Update Profession"],
            ["profession_delete", "Delete Profession"],
        ]],

        //Firm Size 
        ["firmSize", "Firm Size", "access" => [
            ["firmSize_list", "Show Firm Size Table"],
            ["firmSize_create", "Create Firm Size"],
            ["firmSize_update", "Update Firm Size"],
            ["firmSize_delete", "Delete Firm Size"],
        ]],

        //Fund Size 
        ["fundSize", "Fund Size", "access" => [
            ["fundSize_list", "Show Fund Size Table"],
            ["fundSize_create", "Create Fund Size"],
            ["fundSize_update", "Update Fund Size"],
            ["fundSize_delete", "Delete Fund Size"],
        ]],

        //service Offer 
        ["serviceOffer", "Service Offer", "access" => [
            ["serviceOffer_list", "Show Service Offer Table"],
            ["serviceOffer_create", "Create Service Offer"],
            ["serviceOffer_update", "Update Service Offer"],
            ["serviceOffer_delete", "Delete Service Offer"],
        ]],

        //Primary Region 
        ["primaryReason", "Primary Region", "access" => [
            ["primaryReason_list", "Show Primary Region Table"],
            ["primaryReason_create", "Create Primary Region"],
            ["primaryReason_update", "Update Primary Region"],
            ["primaryReason_delete", "Delete Primary Region"],
        ]],

        //Subscription Primary Region 
        ["subscribePrimaryReason", " Subscription Regions", "access" => [
            ["subscribePrimaryReason_list", "Show  Primary Subscription Locations Table"],
            ["subscribePrimaryReason_create", "Create  Subscription Regions"],
            ["subscribePrimaryReason_update", "Update  Subscription Regions"],
            ["subscribePrimaryReason_delete", "Delete  Subscription Regions"],
        ]],

        //Location Postcode 
        ["postcode", "Primary Postcodes", "access" => [
            ["postcode_list", "Show Primary Postcodes Table"],
            ["postcode_deleted_list", "Show Deleted Primary Postcode Table"],
            ["postcode_create", "Create Primary Postcodes"],
            ["postcode_update", "Update Primary Postcodes"],
            ["postcode_delete", "Delete Primary Postcodes"],
            ["postcode_restore", "Restore Primary Postcodes"],
        ]],

        //Subscription Location Postcode 
        ["subscribePostcode", "Subscription Postcodes", "access" => [
            ["subscribePostcode_list", "Show Subscription Postcodes Table"],
            ["subscribePostcode_create", "Create Subscription Postcodes"],
            ["subscribePostcode_update", "Update Subscription Postcodes"],
            ["subscribePostcode_delete", "Delete Subscription Postcodes"],
        ]],

        //subscription
        ["subscription", "Subscription", "access" => [
            ["subscription_list", "Show Subscription Table"],
            ["subscription_create", "Create Subscription"],
            ["subscription_update", "Update Subscription"],
            ["subscription_delete", "Delete Subscription"],
        ]],

        //testimonial
        ["testimonial", "Testimonial", "access" => [
            ["testimonial_list", "Show Testimonial Table"],
            ["testimonial_create", "Create Testimonial"],
            ["testimonial_update", "Update Testimonial"],
            ["testimonial_delete", "Delete Testimonial"],
        ]],

        //communication
        ["communication", "Communication", "access" => [
            ["communication_list", "Show Communication Table"],
            ["communication_create", "Create Communication"],
            ["communication_update", "Update Communication"],
            ["communication_delete", "Delete Communication"],
        ]],        

        // Blogs
        ["blog", "Blog", "access" => [
            ["blog", "Show Blog Table"],
            ["blog_create", "Create Blog"],
            ["blog_update", "Update Blog"],
            ["blog_delete", "Delete Blog"],
        ]],

        // Advisor Blogs
        ["advisor_blog", "Advisor Blog", "access" => [
            ["advisor_blog", "Show Advisor Blog Table"],
            ["advisor_blog_create", "Create Advisor Blog"],
            ["advisor_blog_update", "Update Advisor Blog"],
            ["advisor_blog_delete", "Delete Advisor Blog"],
        ]],
        
        // Terms & Condition
        ["terms_&_condition", "Dynamic Pages", "access" => [
            ["terms_&_condition_list", "Dynamic Pages Table Show"],
            ["terms_&_condition_create", "Dynamic Pages Create"],
            ["terms_&_condition_update", "Dynamic Pages Update"],
            ["terms_&_condition_udelete", "Dynamic Pages Delete"],
        ]],

        // Enquires
        ["enquires", "Enquires", "access" => [
            ["enquires", "Show Enquire / Contact Table"],
            ["enquires_delete", "Delete Enquires Info"],
        ]],

        // Tips & Guides
        ["tips_guides", "Tips & Guides", "access" => [
            ["tips_guides_list", "Show Tips & Guides Table"],
            ["tips_guides_create", "Create Tips & Guides"],
            ["tips_guides_update", "Update Tips & Guides"],
            ["tips_guides_delete", "Delete Tips & Guides"],
        ]],

        // Quick Links
        ["quick_links", "Quick Links", "access" => [
            ["quick_link_list", "Show Quick Links Table"],
            ["quick_link_create", "Create Quick Link"],
            ["quick_link_update", "Update Quick Link"],
            ["quick_link_delete", "Delete Quick Link"],
        ]],

        // Advisor Quick Links
        ["advisor_quick_links", "Advisor Quick Links", "access" => [
            ["advisor_quick_link_list", "Show Advisor Quick Links Table"],
            ["advisor_quick_link_create", "Create Advisor Quick Link"],
            ["advisor_quick_link_update", "Update Advisor Quick Link"],
            ["advisor_quick_link_delete", "Delete Advisor Quick Link"],
        ]],

        // Pages
        ["page", "Page", "access" => [
            ["page_list", "Show Page Table"],
            ["page_create", "Create New Page"],
            ["page_update", "Update Page"],
            ["page_delete", "Delete Page"],
        ]],

        // FAQ
        ["faq", "FAQ", "access" => [
            ["faq_list", "Show FAQ Table"],
            ["faq_create", "Create New FAQ"],
            ["faq_update", "Update FAQ"],
            ["faq_delete", "Delete FAQ"],
        ]],

        // FAQ
        ["social_media", "Social Media", "access" => [
            ["social_media_list", "Show Social Media Table"],
            ["social_media_create", "Create New Social Media"],
            ["social_media_update", "Update Social Media"],
            ["social_media_delete", "Delete Social Media"],
        ]],

        // Email Setup
        ["Email", "Email Settings", "access" => [
            ["email_send", "Email Send"],
            ["email_template", "Email Template" ],
            ["email_template_delete", "Email Template Delete" ],
            ["email_configuration", "Email Configuration Setup"],
        ]],

        // Fetchfy Configuration
        ["fetchfy_configuration", "Fetchfy Configuration", "access" => [
            ["fetchfy_configuration_list", "Fetchfy Configuration Table Show"],
            ["fetchfy_configuration_create", "Fetchfy Configuration Create" ],
            ["fetchfy_configuration_update", "Fetchfy Configuration Update" ],
            ["fetchfy_configuration_delete", "Fetchfy Configuration Delete"],
        ]],

        // Website Settings
        [ "setting", "Website Settings", "access" => [
            ["setting", "Website Settings Create & Update"]
        ]],
        
        ["group", "Show Permission Group", "access" => [
            ["group_list",  "Group Table Show"],
            ["group_create", "Create Permission Group"],
            ["group_update", "Update Permission Group"],
            ["group_delete", "Delete Permission Group"],
            ["group_permission", "Create or Update Group Access"]
        ]],
        
    ];

    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'name', 'total_user', 'role', 'description', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'name', 'total_user', 'role', 'description', 'action'];
        return $columns;
    }

    /**
     * Check Access is Present or Not
     */
    public static function hasAccess($access_arr){
        if( !is_array($access_arr) ){
            $access_arr = [$access_arr];
        }

        $permissions = (new AccessController())->getAccessPermission();
        foreach($access_arr as $key){
            if( in_array($key, $permissions) ){
                return true;
            }
        }
    }

    

    /**
     * Show Admin List  without Archive
     */
    public function index(Request $request){        
        if( $request->ajax() ){
            return $this->getDataTable();
        }
        $params = [
            'nav'               => 'group',
            'subNav'            => 'group.list',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("group_create") ? route('group.create') : false,
            'pageTitle'         => 'Group List',
            'tableStyleClass'   => 'bg-success'
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Admin
     */
    public function create(Request $request){
        $params = [ 
            "title" => "Group Create",
            "form_url"  => route('group.create'),
        ];
        $this->saveActivity($request, "Add New Group Page Open");
        return view('backEnd.group.create', $params)->render();
    }

    /**
     * Store Admin Information
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                'name'          => ['required','string','min:2', 'max:100']
            ]);
            if( $request->id == 0 ){                
                if( $validator->fails()){
                    $this->message = $this->getValidationError($validator);
                    $this->modal = false;
                    return $this->output();
                }
                $data = new Group();
                $this->saveActivity($request, "Add New Group");
            }else{
                $data = Group::find($request->id);
                $this->saveActivity($request, "Update Group", $data);
            }
            $data->name = $request->name;
            $data->description = $request->description;
            $data->is_admin = $request->is_admin ?? 0;
            $data->save();
            $this->success('Group information added successfully');
        }catch(Exception $e){
            $this->message = $this->getError($e);
        }
        return $this->output();
    }

    /**
     * Edit Admin Info
     */
    public function edit(Request $request){

        $params = [
            "title"     => "Group Edit",
            "form_url"  => route('group.create'),
            'data'      => Group::find($request->id),
        ];
        $this->saveActivity($request, "Edit Group");
        return view('backEnd.group.create', $params)->render();
    }

    /**
     *  Delete
     */
    public function delete(Request $request){
        Group::where("id", $request->id)->delete();
        $this->success("Deleted successfully");
        $this->saveActivity($request, "Delete Group");
        return $this->output();
    }

    /**
     * Get Admin DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getDataTable($type = 'list'){
        $data = Group::orderBy('name', 'ASC')->get();

        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })            
            ->addColumn('role', function($row){ return $row->is_admin ? "Super Admin" : "Others"; })
            ->addColumn('total_user', function($row){ return $row->admins->count() ?? 0; })
            ->addColumn('action', function($row) use($type){ 
                $li = "";
                if(AccessController::checkAccess("group_update")){
                    $li .= '<a href="'.route('group.edit', [$row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span>Edit </a> ';
                }
                if(AccessController::checkAccess("group_permission")){
                    $li .= '<a href="'.route('group.permission', [$row->id]).'" class="btn btn-sm btn-warning" title="Permission" > <span class="fa fa-key"></span> Permission </a> ';
                }
                if(AccessController::checkAccess("group_delete")){                    
                    $li .= '<a href="'.route('group.delete', [$row->id]).'" class="ajax-click btn btn-sm btn-danger" > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }
                return $li;
            })
            ->rawColumns(['action', "description"])
            ->make(true);
    }

    /**
     * Group Permission
     */
    public function permission(Request $request){
        $group = Group::find($request->id);
        $params = [
            'nav'       => 'group',
            'subNav'    => 'group.list',
            "title"     => "Group Permission",
            "form_url"  => route('group.permission', [$request->id]),
            'group'      => $group,
            "accesses"  => $this->accesses,
            "permissions" => $group->group_accesses->group_access ?? [],
        ];
        $this->saveActivity($request, "Group Permission Page Open");
        return view('backEnd.group.permission', $params);
    }

    /**
     * Store Access Group Permission
     */
    public function storePermission(Request $request){
        try{
            $group_access = GroupAccess::where("group_id", $request->id)->first();
            if( empty($group_access) ){
                $group_access = new GroupAccess();
            }
            $group_access->group_id = $request->id;
            $group_access->group_access = $request->permission;
            $group_access->save();

            $group_permission = Auth::user()->group->group_accesses->group_access ?? [];
            Session::put('group_permission', $group_permission);
        
            $this->saveActivity($request, "Update Group Permission");
            return back()->with('success', "Group permission updated successfully");
        }catch(Exception $e){
            return back()->with('error', $this->getError($e));
        }
    }

    public static function checkAccess($access_arr){
        if( !is_array($access_arr) ){
            $access_arr = [$access_arr];
        }

        $permissions = (new AccessController())->getAccessPermission();
        foreach($access_arr as $key){
            if( in_array($key, $permissions) ){
                return true;
            }
        }
    }

    protected function getAccessPermission(){
        if(Session::has('group_permission')){
            return Session::get('group_permission');
        }
        $group_permission = Auth::user()->group->group_accesses->group_access ?? [];
        Session::put('group_permission', $group_permission);
        return $group_permission;
    }

}

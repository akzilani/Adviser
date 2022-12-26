<?php

namespace App\Http\Controllers\BackEnd;

use App\EmailConfiguration;
use App\EmailOption;
use App\EmailTemplate;
use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Notifications\EmailNotification;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmailController extends Controller
{
    /**
     * Send Mail Page Show
     */
    public function sendMailPage(){
        $params = [
            'nav'       => "email",
            'subNav'    => "send",
            "title"     => "Mail Send",
            "form_url"  => route("email.send"),
            "advisors"  => User::all(),
        ];
        return view('backEnd.email.email-send', $params);
    }

    /**
     * Send Email
     */
    public function sendMail(Request $request){
        $advisor_arr = $request->advisor;
        $subject = $request->subject;
        $message = $request->message;
        SendMail::dispatch($advisor_arr, $subject, $message);
        return back()->with("success", "Email sent successfully");
    }

    /**
     * Mail Configuration Page Show
     */
    public function configurePageShow(Request $request){
        $params = [
            'nav'       => "email",
            'subNav'    => "configuration",
            "title"     => "Email Configuration",
            "form_url"  => route("email.configuration"),
            "data"      => EmailConfiguration::first(),
        ];
        //$this->saveActivity($request, "Email Configuration Page Open");
        return view('backEnd.email.configure', $params);
    }

    /**
     * Save Configuration
     */
    public function saveConfigure(Request $request){
        $insert_data = $request->except(["_token"]);
        $config = EmailConfiguration::first();
        EmailConfiguration::where('id', $config->id)->update($insert_data);
        $this->saveActivity($request, "Update Configuration Page");
        return back()->with("success", "Configuration updated successfully");
    }

    /**=====================================================================================================
     * Email Template
     * =====================================================================================================
     */
    /**
     * Get Table Column List
     */
    private function getColumns(){
        $columns = ['#', 'type', 'subject', 'footer', "send_mail", "send_to_cc", "third_party_email_send", "third_party_email", 'body', 'action'];
        return $columns;
    }

    /**
     * Get DataTable Column List
     */
    private function getDataTableColumns(){
        $columns = ['index', 'type', 'subject', 'footer', "send_mail", "send_to_cc", "third_party_email_send", "third_party_email", 'body', 'action'];
        return $columns;
    }

    private function getEmailOptions($except){
        if( !is_array($except) ){
            $except = (array) $except;
        }
        $email_types = [
            "signup_email"                      => "signup_email",
            "welcome_email"                     => "welcome_email", 
            "account_verification_email"        => "account_verification_email", 
            "terms_&_conditions_email"          => "terms_&_conditions_email",
            "password_reset_email"              => "password_reset_email", 
            "match_me_lead_notification_email"  => "match_me_lead_notification_email", 
            "search_local_notification_email"   => "search_local_notification_email", 
            "auction_creation_email"            => "auction_creation_email", 
            "auction_bid_email"                 => "auction_bid_email", 
            "auction_outbid_email"              => "auction_outbid_email", 
            "auction_win_email"                 => "auction_win_email",
            "auction_cancelled_email"           => "auction_cancelled_email",
            "match_me_lead_referral"            => "match_me_lead_referral",
            "search_local_lead_referral"        => "search_local_lead_referral",
            "buy_out_activated_mail"            => "buy_out_activated_mail",
        ];
        foreach($except as $type){
            unset($email_types[$type]);
        }
        return $email_types;
    }

    /**
     * Get Current Table Model
     */
    private function getModel(){
        return new EmailTemplate();
    }

    public function templateList(Request $request){
        if($request->ajax()){
            return $this->getEmailTemplateDatatable($request);
        }

        //$this->saveActivity($request, "Email Templete Table Show");
        $params = [
            'nav'               => 'email',
            'subNav'            => 'template',
            'tableColumns'      => $this->getColumns(),
            'dataTableColumns'  => $this->getDataTableColumns(),
            'dataTableUrl'      => Null,
            'create'            => AccessController::checkAccess("email_template") ? route('email.template.create') : Null,
            'pageTitle'         => 'Email Template List',
            'tableStyleClass'   => 'bg-success',
            "modalSizeClass"    => "modal-lg"
        ];
        return view('backEnd.table', $params);
    }

    /**
     * Create New Template
     */
    public function templateCreate(Request $request){
        $type_exists = $this->getModel()->select("type")->get()->pluck("type")->toArray();
        $params = [
            "title"     => "Create Email Template",
            "form_url"  => route('email.template.create'),
            "types"     => $this->getEmailOptions($type_exists),
        ]; 
        //$this->saveActivity($request, "Create Email Templete Page Open");
        return view('backEnd.email.template-create', $params)->render();
    }

    

    /**
     * Save Template Data
     */
    public function templateSave(Request $request){
        $input_data = $request->except(['_token',"id"]);
        if($request->id == 0){
            $input_data['created_by'] = $request->user()->id;
            EmailTemplate::insert($input_data);
            $message = "Template info added Successfully";
            $this->saveActivity($request, "Add New Email Templete");
        }else{
            $message = "Template info updated Successfully";
            $input_data['updated_by'] = $request->user()->id;
            EmailTemplate::where('id', $request->id)->update($input_data);
            $this->saveActivity($request, "Update Email Templete");
        }
        $this->success($message);
        return $this->output();
    }

    /**
     * Template Edit
     */
    public function templateEdit(Request $request){
        $data = EmailTemplate::find($request->id);
        $type_exists = $this->getModel()->select("type")->get()->pluck("type")->toArray();
        $type_arr = $this->getEmailOptions($type_exists);
        $type_arr[$data->type] = $data->type;
        $params = [
            "title"     => "Update Email Template",
            "form_url"  => route('email.template.create'),
            "data"      => $data,
            "types"     => $type_arr,
        ]; 
        //$this->saveActivity($request, "Edit Email Templete Page Open");
        return view('backEnd.email.template-create', $params)->render();
    }

    /**
     * Templete Delete
     */
    public function templateDelete(Request $request){
        $data = EmailTemplate::find($request->id);
        $data->delete();
        $this->success("Your email template info has been deleted successfully");
    }


    /**
     * Get Communication   DataTable
     * Type will be list & archive
     * Default Type is list
     */
    protected function getEmailTemplateDatatable(){
        $data = $this->getModel()->orderBy('id', 'ASC')->get();
        return DataTables::of($data)
            ->addColumn('index', function(){ return ++$this->index; })
            ->editColumn("type", function($row){ return ucwords(str_replace("_"," ",$row->type)); })
            ->editColumn("body", function($row){ return wordwrap($row->body,"60", "<br>"); })
            ->editColumn("footer", function($row){ return wordwrap($row->footer,"60", "<br>"); })
            ->editColumn("send_mail", function($row){ return $row->send_email == 1 ? 'ON' : "OFF"; })
            ->editColumn("send_to_cc", function($row){ return $row->send_to_cc == 1 ? 'ON' : "OFF"; })
            ->addColumn("third_party_email_send", function($row){ return $row->third_party_email_send == 1 ? 'ON' : "OFF"; })
            ->addColumn("third_party_email", function($row){ return $row->third_party_email ?? "N/A"; })
            ->addColumn('action', function($row){
                $li = "";
                if(AccessController::checkAccess("email_template")){
                    $li = '<a href="'.route('email.template.edit',['id' => $row->id]).'" class="ajax-click-page btn btn-sm btn-info" title="Edit" > <span class="fa fa-edit"></span> </a> ';
                }
                if(AccessController::checkAccess("email_template_delete")){
                    $li .= '<a href="'.route('email.template.delete',['id' => $row->id]).'" class="ajax-click btn btn-sm btn-danger " > <span class="fa fa-trash" title="Delete" ></span> </a> ';
                }
                return $li;
            })            
            ->rawColumns(['action', 'publication_status', "body" ])
            ->make(true);
    }
}

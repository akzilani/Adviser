<?php

namespace App\Http\Controllers\BackEnd\Auth;

use App\Http\Controllers\Controller;
use App\SubscriptionPlan;
use App\User;
use App\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo;
    protected $logoutRedirect;
    protected $maxAttempts = 3;
    protected $decayMinutes = 15;

    function __construct()
    {
        $this->redirectTo = route("admin.dashboard");
        $this->logoutRedirect = route("admin.login");
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if( Auth::guard('admin')->check() ){
            return redirect($this->redirectTo);
        }
       
        return view('backEnd.admin.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * After Logout the redirect location
     */
    protected function loggedOut(){
        return redirect($this->logoutRedirect);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username()   => 'required|string',
            'password'          => 'required|string|min:3',
        ]);
    }

    /**
     * Show Dashboard
     */
    public function showDashboard(Request $request){
        //$this->saveActivity($request, "Load Admin Panel");
        if( $request->ajax() ){
            return $this->getDataTable($request);
        }
        $prams['today_register'] = User::where('created_at', '>=', date('Y-m-d') .' 00:00:00' )->count();
        // $prams['total_register'] = User::withTrashed()->count();
        $prams['total_register'] = User::whereHas("subscription_plan", function($qry){
            $qry->where("office_manager", false);
        })->count();
        $prams['total_office_manager'] = User::whereHas("subscription_plan", function($qry){
            $qry->where("office_manager", true);
        })->where('office_manager_id', null)->count();
        $prams['today_visit'] = Visitor::where('date', '=', date('Y-m-d'))->sum('visit_count');
        $prams['total_visitor'] = Visitor::count('id');   
        $prams['plans'] = SubscriptionPlan::all();
        $prams['nav'] = "dashboard";
        return view('backEnd.dashboard.index',$prams);
    }
}

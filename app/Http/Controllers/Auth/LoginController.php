<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
                
        if(Session::has('login_page')){
            Session::pull('login_page');
            return view('auth.login');            
        }else{
            Session::put('login_page', 'first_page');
            return view('auth.login2');
        }
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => 'recaptcha',
            $this->username() => 'required|string',
            'password' => 'required|string',
        ],[
            "recaptcha" => "Capture code validation required",
        ]);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }
        
        //get id and name
        $id = $request->user()->id;
        $name = User::where('id',$id)->first(['first_name'])->first_name;

        $office_manager = $request->user()->subscription_plan->office_manager ?? false;
        
        //new activity show
        if($office_manager){
            $message = "Office Manager Logged in";
            $msg = implode(' ', array($message));
            $this->saveActivity($request,$msg,$name);
        }
        else{
            $message = "Advisor Logged in";
            $msg = implode(' ', array($message));
            $this->saveActivity($request,$msg,$name);
        }
        
        if($office_manager){
            Auth::guard("office_manager")->login($request->user());
        }
        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }
}

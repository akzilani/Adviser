<?php

namespace App\Http\Controllers;

use App\User;
use App\Blogs;
use App\Pages;
use App\FundSize;
use App\Testimonial;
use App\ServiceOffer;
use App\TipsAndGuides;
use App\AdvisorQuestion;
use App\TremsAndCondition;
use App\PromotionalAdvisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function backEndIndex()
    {
        return redirect()->route('advisor.dashboard');
    }

    /**
     * FrontEnd Index Page
     */
    public function frontEndIndex(){
        $advisors = User::join('promotional_advisors as PA', 'PA.advisor_id', '=', 'advisors.id')
            ->leftJoin('advisor_questions as aq', "aq.advisor_id", "advisors.id")
            ->where('PA.publication_status', 1)
            ->select('advisors.*', DB::raw("IF(aq.publication_status = 1 and aq.deleted_at IS NULL, count(aq.id), 0) as rating"), 'PA.position')
            ->orderBy('position','asc')->groupBy('id')->get();
        $params = [
            "area_of_advices"        => TipsAndGuides::where('publication_status', true)->where('type', '!=','others')->paginate(4),
            'testimonials'           => Testimonial::where('publication_status', true)->orderBy('id', 'desc')->take(6)->get(),
            'active_advisor'         => User::where('status', 'active')->count(),
            "total_mortgage_advisor" => User::where("status", 'active')->whereHas('profession', function($qry){ $qry->where('name', 'Mortgage Advisor'); })->count(),
            "service_offers"         => ServiceOffer::where('publication_status', true)
            ->orderBy('position','asc')->groupBy('id')->get(),
            "advisors"               => $advisors,
            "total_advisor"          => User::where("status", 'active')->whereHas("subscription_plan", function($qry){
                $qry->where("office_manager", false);
            })->count(),
            "total_question"         => AdvisorQuestion::where("publication_status", true)->count(),
            "total_testimonial"      => Testimonial::where("publication_status", true)->count(),
            "total_5_rating"         => DB::select('SELECT count(advisor_id) total_advisor from (SELECT count("id") as total_qs, `advisor_id` FROM advisor_questions WHERE `publication_status` = 1 GROUP By(advisor_id)) as Table2 where(total_qs >= 5) ')[0]->total_advisor,
            "blogs"                  => Blogs::where('publication_status', 1)->orderBy('id', 'DESC')->paginate(4),
            "fund_sizes"             => FundSize::orderBy("min_fund", "ASC")->get(),
            "cookies"                => !Session::has("cookies") ? TremsAndCondition::where("type", "Cookies")->orderBy('id','DESC')->first() : null,
            "page"                   => Pages::getPage("home_page"),
            "footers"                => TremsAndCondition::where("type", "Footer_CopyRight")->get(),
        ];
        Session::put("cookies", "Already Show");
        return view('frontEnd.home.index', $params);
    }

    public function cron(){
        Artisan::call("schedule:run");
        return "Success";
    }
}

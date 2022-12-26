<?php

namespace App\Http\Controllers\FrontEnd;

use App\AdvisorBlog;
use App\AdvisorQuickLink;
use App\Blogs;
use App\Http\Controllers\Controller;
use App\QuickLinks;
use App\TremsAndCondition;
use Illuminate\Http\Request;
use App\Pages;

class BlogController extends Controller
{
    /**
     * View Blog Post list
     */
    public function showList(){
        $dynamic_page= TremsAndCondition::where("type", "Popup Page")->first();        
        $params = [
            "page"                  => Pages::getPage("blogs_page"),
            'blogs' => Blogs::where('publication_status', 1)->orderBy('id', 'DESC')->paginate(12),
            'quick_links'    => QuickLinks::where('publication_status', 1)->orderBy('id', 'ASC')->get(),
            "dynamic_popup"  => $dynamic_page->trems_and_condition ?? "",
        ];
        return view('frontEnd.blog.list', $params);
    }

    /**
     * View Post
     */
    public function viewPost(Blogs $blog, Request $request){
        $dynamic_page= TremsAndCondition::where("type", "Popup Page")->first();
        $params = [
            'post' => $blog,
            'quick_links'    => QuickLinks::where('publication_status', 1)->orderBy('id', 'ASC')->paginate(20),
            "dynamic_popup"  => $dynamic_page->trems_and_condition ?? "",
        ];
        return view('frontEnd.blog.view', $params);
    }

    /**
     * View Advisor Blog Post
     */
    public function viewAdvisorPost(AdvisorBlog $advisor_blog, Request $request){
        $params = [
            'post' => $advisor_blog,
            'quick_links'    => AdvisorQuickLink::where('publication_status', 1)->orderBy('id', 'ASC')->paginate(20),
        ];
        return view('frontEnd.blog.advisor-post-view', $params);
    }
}

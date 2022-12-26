<?php

namespace App\Http\Middleware;

use App\Http\Components\Traits\Visitor as VisitorTraits;
use App\Visitor;
use Closure;
use Exception;
use Illuminate\Support\Facades\Session;

class VisitorMiddleware
{
    use VisitorTraits;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try{
            if(Session::has('visitor_id')){
                $data = Visitor::find(Session::get('visitor_id'));
                $data->visit_count += 1;
                // $data->user_id = !empty($request->user()) ? $request->user()->id : Null;
                $data->save();
            }else{
                try{
                    $data = $this->storeVisitorData($request, true);                
                }catch(Exception $e){
                    $data = $this->storeVisitorData($request, false);
                }
                Session::put('visitor_id',$data->id); 
                Session::save();               
            }
        }catch(Exception $ex){
            return $next($request);
        }
        return $next($request);
    }
}

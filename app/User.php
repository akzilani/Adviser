<?php

namespace App;

use App\Notifications\EmailVerification;
use App\Notifications\PasswordReset;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;

    protected $table = "advisors";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at'     => "datetime",
        "location_postcode_id"  => "array",
        "advisor_type_id"       => "array",
        "service_offered_id"    => "array",
        "subscribe"             => "boolean",
        "is_live"               => "boolean",
        'subscribe_primary_region_id'   => "array",
        'subscribe_location_postcode_id'=> "array",
        "specific_rating"       => "array"
    ];

    public function firm_details(){
        return $this->hasOne(FirmDetails::class, 'advisor_id');
    }

    public function fund_size(){
        return $this->belongsTo(FundSize::class, 'fund_size_id')->withTrashed();
    }

    public function billing_info(){
        if( empty($this->office_manager_id) ){
            return $this->hasOne(AdvisorBillingInfo::class, 'advisor_id');
        }else{ 
            return $this->hasOne(AdvisorBillingInfo::class, "advisor_id", 'office_manager_id');
        }
    }

    public function officeManager(){
        return $this->belongsTo(User::class, 'office_manager_id');
    }

    public function primary_reason(){
        return $this->belongsTo(PrimaryReason::class, 'primary_region_id')->orderBy('position', 'ASC')->withTrashed();
    }

    public function subscribe_primary_reason(){
        $subscribe_reason = $this->subscribe_primary_region_id;
        if( !is_array($subscribe_reason) ){
            $subscribe_reason = (array)$subscribe_reason;
        }
        $all_reasons = SubscribePrimaryReason::whereIn('id', $subscribe_reason)->select('name')->get()->pluck('name');
        $all_reasons = $all_reasons->toArray();
        return implode(",  ",$all_reasons);
    }

    public function subscription_plan(){
        if( empty($this->office_manager_id) ){
            return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id')->orderBy('id', "DESC")->withTrashed();
        }else{ 
            return $this->hasOneThrough(SubscriptionPlan::class, User::class, "id", "id", 'office_manager_id', "subscription_plan_id")->withTrashed();
        }
    }

    public function profession(){
        return $this->belongsTo(Profession::class, "profession_id")->withTrashed();
    }

    public function testimonial(){
        return $this->hasMany(Testimonial::class, 'advisor_id');
    }
    public function published_testimonials(){
        return $this->hasMany(Testimonial::class, 'advisor_id')->where('publication_status', 1);
    }

    public function approve_advisor_questions(){
        return $this->hasMany(AdvisorQuestion::class, 'advisor_id')->where("publication_status", true);
    }

    public function approve_public_questions(){
        return $this->hasMany(AdvisorQuestion::class, 'advisor_id')->where("publication_status", true)->where('visibility', 'public');
    }

    public function advisor_questions(){
        return $this->hasMany(AdvisorQuestion::class, 'advisor_id');
    }

    public function compliance(){
        return $this->hasMany(AdvisorCompliance::class, 'advisor_id');
    }

    public function  interviews(){
        return $this->hasMany(Interview::class, 'advisor_id')->where('publication_status', 1);
    }

    public function leads(){
        return $this->hasMany(Leads::class, "advisor_id");
    }
    public function advisor_profiles(){
        return self::where("office_manager_id", $this->id)->get();
    }

    public function getMatchRatingStart($service_offer_id){
        $total_question = AdvisorQuestion::where('advisor_id', $this->id)->where('service_offer_id', $service_offer_id)->count();
        $star_rate = MatchRating::getSpecifyStarRatingRate($this->subscription_plan_id, $service_offer_id);
        return ($star_rate * $total_question);
    }

    /**
     * Send the Email Verification Email;
     *
     * @return void
     */
    public function sendEmailVerificationNotification(){
        $this->notify(new EmailVerification($this));
    }

    /**
     * Send the Password Reset Email 
     * Through Implement The Interface
     * mathod sendPasswordResetNotification();
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token, $this));
    }

    public function postcodesCovered($post_code_arr = Null, $subscribe = false){
        if(!$subscribe){
            $post_code_arr = empty($post_code_arr) ? $this->location_postcode_id : $post_code_arr;
            $post_code_arr = !empty($post_code_arr) ? $post_code_arr : [];
            $datas = LocationPostCodes::whereIn('id', $post_code_arr)->select('short_name')->get()->pluck('short_name');
        }else{
            $post_code_arr = empty($post_code_arr) ? $this->subscribe_location_postcode_id : $post_code_arr;
            $post_code_arr = !empty($post_code_arr) ? $post_code_arr : [];
            $datas = SubscribePostCodes::whereIn('id', $post_code_arr)->select('short_name')->get()->pluck('short_name');
        }      
        $datas = count($datas) > 0 ? $datas->toArray() : [];
        return implode(",  ",$datas);
    }
    

    public function advisor_types($type_arr){
        if( is_array($type_arr) && count($type_arr) > 0 ){
            return AdvisorType::whereIn('id', $type_arr)->withTrashed()->get();
        }
        return [];
    }

    public function service_offered($offered_arr = Null){
        if( empty($offered_arr) ){
            $offered_arr = $this->service_offered_id;
        }
        if( is_array($offered_arr) && count($offered_arr) > 0 ){
            return ServiceOffer::whereIn('id', $offered_arr)->withTrashed()->get();
        }
        return [];
    }

    public function profile_visitor($type = "monthly"){
        $data = Visitor::where('user_id', $this->id);
        if($type == "monthly"){
            $data = $data->where('date', '>=', Carbon::now()->firstOfMonth()->format('Y-m-d'));
        }
        return $data->get();
    }
}

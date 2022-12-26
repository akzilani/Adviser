<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@backEndIndex')->name('home');
Route::get('/scheduler/run', 'HomeController@cron');
route::get('/validate', "FrontEnd\VerificationController@verify");

/**
 * Visitor Middleware
 */
Route::middleware(['visitor'])->group(function () {  
    /**
     * Open Routes
     */     
    Route::get('/', 'HomeController@frontEndIndex')->name('index');
    Route::post('/ask-question', 'FrontEnd\SearchController@askNow')->name('quick_question');
    Route::get('/advisor-list/{advisor_type?}', "FrontEnd\SearchController@advisorList")->name('search_advisor');
    Route::get('/find-advisor', "FrontEnd\SearchController@findAdvisor")->name('find_advisor');
    Route::get('{advisor_id}/advisor-contact', 'FrontEnd\AdvisorController@showContactForm')->name('contact_advisor');
    Route::post('{advisor_id}/advisor-contact', 'FrontEnd\AdvisorController@contact');
    Route::get('advisor/contact-successfully', 'FrontEnd\AdvisorController@contactSuccessfully')->name('contact_successfully');

    Route::prefix('advisor')->name('advisor.')->group(function(){
        Route::get('plans', 'FrontEnd\AdvisorController@subscriptionPlans')->name('subscription_plan');
        Route::get('{id}/choose', 'FrontEnd\AdvisorController@subscriptionPlanChoose')->name('subscription_plan_choose');
    });
    
    Route::get('about-us','FrontEnd\OthersController@aboutUs')->name('about_us');
    Route::get('contact-us','FrontEnd\OthersController@contactUs')->name('contact_us');
    Route::post('contact-us','FrontEnd\OthersController@saveContactUs');

    Route::get('legal-stuff','FrontEnd\OthersController@legalStuff')->name('legal_stuff');
    Route::get('privacy-policy','FrontEnd\OthersController@privacyPolicy')->name('privacy_policy');
    Route::get('terms-and-condition','FrontEnd\OthersController@termsAndCondition')->name('terms_and_condition');

    Route::get('tips-and-guides','FrontEnd\OthersController@tipsAndGuides')->name('tips_and_guides');
    Route::get('tips-and-guides/{slug}/view','FrontEnd\OthersController@viewTipsAndGuides')->name('view_tips_and_guides');

    Route::get('campain','FrontEnd\OthersController@campain')->name('campain');
    Route::get('need-finalcial-advisor','FrontEnd\OthersController@needFinalCialAdvisor')->name('need_finalcial_advisor');
    Route::get('quick-link/{slug}','FrontEnd\OthersController@viewQuickLink')->name('view_quick_link');
    Route::get('advisor-quick-link/{slug}','FrontEnd\OthersController@viewAdvisorQuickLink')->name('view_advisor_quick_link');
    Route::get('view-questions/{id}/{service}', 'FrontEnd\OthersController@viewAllQuestions')->name('service_view_all_questions');
    Route::get('view-question/{question_id}/{service}', 'FrontEnd\OthersController@viewQuestions')->name('service_view_question');

    Route::get('blogs', 'FrontEnd\BlogController@showList')->name('blogs');
    Route::get('blog/{blog:slug}', 'FrontEnd\BlogController@viewPost')->name('view_blog');
    Route::get('advisor-blog/{advisor_blog:slug}', 'FrontEnd\BlogController@viewAdvisorPost')->name('view_advisor_blog');

    // Registration
    Route::get('register/step2', 'FrontEnd\AdvisorController@registerStep2')->name('advisor.register_setp2');
    Route::post('register/step2', 'FrontEnd\AdvisorController@storeStep2');

    // Advisor Profile
    Route::get('advisor-profile/{profession}/{location}/{name_id}','FrontEnd\AdvisorController@advisorProfile')->name('advisor_profile');
});




/**********************************************************************************************
 * Advisor Panel
 *********************************************************************************************/
Route::middleware(['auth', 'visitor'])->name('advisor.')->prefix('advisor')->group(function(){
    

    Route::get('/email/not-verified','FrontEnd\AdvisorController@showEmailNotVerifyPage')->name('email.not_verify');
    Route::get('verification/email-send','FrontEnd\AdvisorController@sendVerificationEmail')->name('verify.email_send');
    Route::get('logout','Auth\LoginController@logout')->name('logout');
    
    Route::middleware(['verified:advisor.email.not_verify'])->group(function(){

        Route::middleware(["incomplete_profile"])->group(function(){
            
            // Dashboard
            Route::get('dashboard','FrontEnd\AdvisorController@dashboard')->name('dashboard');
            
            /**
             * Compliance
             */
            Route::prefix('compliance')->name('compliance.')->group(function () {
                Route::get('list', 'FrontEnd\ComplianceController@index')->name('list');
                Route::get('create', 'FrontEnd\ComplianceController@create')->name('create');
                Route::post('create', 'FrontEnd\ComplianceController@store');
                Route::get('/{id}/edit','FrontEnd\ComplianceController@edit')->name('edit');
                Route::get('{id}/delete', 'FrontEnd\ComplianceController@delete')->name('delete');
            });
            
            /**
             * Interview
             */
            Route::prefix('interview')->name('interview.')->group(function () {
                Route::get('list', 'FrontEnd\InterviewController@index')->name('list');
                Route::get('create', 'FrontEnd\InterviewController@create')->name('create');
                Route::post('create', 'FrontEnd\InterviewController@store');
                Route::get('/{id}/edit','FrontEnd\InterviewController@edit')->name('edit');
                Route::get('{id}/delete', 'FrontEnd\InterviewController@delete')->name('delete');
            });
            
            /**
             * Advisor Question
             */
            Route::prefix('question')->name("question.")->group(function(){
                Route::get('/', 'FrontEnd\QuestionController@index')->name('list');
                Route::get('/create', 'FrontEnd\QuestionController@create')->name('create');
                Route::post('/create', 'FrontEnd\QuestionController@store');
                Route::get('/{id}/edit','FrontEnd\QuestionController@edit')->name('edit');
                Route::get('/{id}/archive','FrontEnd\QuestionController@archive')->name('archive');
            });

            /**
             * Advisor Testimonial
             */
            Route::prefix('testimonial')->name("testimonial.")->group(function(){
                Route::get('/', 'FrontEnd\TestimonialController@index')->name('list');
                Route::get('/create', 'FrontEnd\TestimonialController@create')->name('create');
                Route::post('/create', 'FrontEnd\TestimonialController@store');
                Route::get('/{id}/edit','FrontEnd\TestimonialController@edit')->name('edit');
                Route::get('/{id}/archive','FrontEnd\TestimonialController@archive')->name('archive');
            });
            
            /**
             * Advisor leads
             */
            Route::prefix('leads')->name("leads.")->group(function(){
                Route::get('/', 'FrontEnd\LeadController@index')->name('list');
                Route::get('/{id}/view','FrontEnd\LeadController@view')->name('view');
                Route::get('/{id}/edit','FrontEnd\LeadController@edit')->name('edit');
                Route::post('/{id}/edit','FrontEnd\LeadController@store');
                Route::get('/{id}/archive','FrontEnd\LeadController@archive')->name('archive');
            });

            /**
             * Auction
             */
            Route::prefix('auction')->name("auction.")->group(function(){
                Route::get('/', 'FrontEnd\AuctionController@index')->name('list');
                Route::get('/{id}/view','FrontEnd\AuctionController@view')->name('view');
                Route::get('/{id}/bid','FrontEnd\AuctionController@bidPage')->name('bid');
                Route::post('/{id}/bid','FrontEnd\AuctionController@bid');
                Route::get('/view/condition','FrontEnd\AuctionController@viewTermsAndCondition')->name('terms_and_condition');
                Route::get('/accept/condition','FrontEnd\AuctionController@acceptTermsAndCondition')->name('accept_condition');
            });

            /**
             * Advisor Communication
             */
            Route::prefix('communication')->name("communication.")->group(function(){
                Route::get('/', 'FrontEnd\CommunicationController@index')->name('list');
                Route::get('/{id}/view','FrontEnd\CommunicationController@view')->name('view');
                Route::get('/{id}/archive','FrontEnd\CommunicationController@archive')->name('archive');
            });

            /**
             * Match Rating & Markating Bedge
             */
            Route::get('match-rating', 'FrontEnd\AdvisorController@matchRating')->name('match_rating');
            Route::get('marketing-profile/{service?}', 'FrontEnd\AdvisorController@marketingProfile')->name('marketing_profile');
        });

        /**********************
         * Profile Section
         *********************/
        Route::get('{profession}/{location}/{id}','FrontEnd\AdvisorController@profile')->name('profile');
        Route::get('profile','FrontEnd\AdvisorController@profile')->name('profile_self');
        
        Route::get('profile-visitor/{type?}','FrontEnd\AdvisorController@profileVisitor')->name('visitor');
        Route::get('{id}/contact/email', 'FrontEnd\AdvisorController@contactEmail')->name("contact_email");
        
        Route::get('profile/update', 'FrontEnd\AdvisorController@editProfile')->name('profile_update');
        Route::post('profile/update', 'FrontEnd\AdvisorController@updateProfile');

        Route::get('password-change', 'FrontEnd\AdvisorController@changePasswordPage')->name('password_change');
        Route::post('password-change', 'FrontEnd\AdvisorController@changePassword');

        Route::get('firm/update', 'FrontEnd\AdvisorController@editFirm')->name('firm');
        Route::post('firm/update', 'FrontEnd\AdvisorController@updateFirm');
        
        // Billing Info
        Route::get('billing-info/update', 'FrontEnd\AdvisorController@editBillingInfo')->name('billing_info');
        Route::post('billing-info/update', 'FrontEnd\AdvisorController@updateBillingInfo');
    });

});

// Office Manager Feature
Route::middleware(['auth', 'visitor'])->prefix("office-manager")->name('office_manager.')->group(function(){    
    //Advisor
    Route::get('/{id}/match-rating','FrontEnd\OfficeManager\AdvisorController@viewMatchRating')->name('view_march_rating');
    Route::get('/{id}/{subscribe}/subscribe','FrontEnd\OfficeManager\AdvisorController@subscribe')->name('subscribe');
});

Route::middleware(['auth:office_manager', 'visitor'])->prefix("office-manager")->name('office_manager.')->group(function(){
    /***********************
     * Advisor
     **********************/
    Route::prefix("advisor")->name('advisor.')->group(function(){
        Route::get('/list','FrontEnd\OfficeManager\AdvisorController@index')->name('list');
        Route::get('/deleted-list','FrontEnd\OfficeManager\AdvisorController@deletedAdvisorList')->name('archived_list');
        Route::get('/filter-list/{type?}/{type_value?}','FrontEnd\OfficeManager\AdvisorController@filterAdvisor')->name('filter_list');
        Route::get('/create','FrontEnd\OfficeManager\AdvisorController@create')->name('create');
        Route::post('/create','FrontEnd\OfficeManager\AdvisorController@store');
        Route::get('/{id}/dashboard','FrontEnd\OfficeManager\AdvisorController@dashboard')->name('view');
        Route::get('/{id}/edit','FrontEnd\OfficeManager\AdvisorController@edit')->name('edit');
        Route::get('/{id}/change-password','FrontEnd\OfficeManager\AdvisorController@changePasswordPage')->name('change_password');
        Route::post('/{id}/change-password','FrontEnd\OfficeManager\AdvisorController@changePassword');
        Route::get('/{id}/email/send-verification-link','BackEnd\AdvisorController@sendVerificationEmail')->name('send_email_verification');
        
        Route::get('/billing','FrontEnd\OfficeManager\AdvisorController@advisorBillingList')->name('billing_list');
        Route::get('/view-billing-info','FrontEnd\OfficeManager\AdvisorController@advisorBillingView')->name('billing_info');
        // Route::get('/{id}/view-billing','FrontEnd\OfficeManager\AdvisorController@advisorBillingView')->name('billing_view');
        // Route::get('/{id}/edit-billing','FrontEnd\OfficeManager\AdvisorController@advisorBillingEdit')->name('billing_edit');
        // Route::post('/{id}/edit-billing','FrontEnd\OfficeManager\AdvisorController@advisorBillingSave');
        Route::get('/{id}/view-postcode','FrontEnd\OfficeManager\AdvisorController@viewPostcodes')->name('view-postcode');
        
        Route::get('/{id}/archive','FrontEnd\OfficeManager\AdvisorController@archive')->name('archive');
        Route::get('/{id}/restore','FrontEnd\OfficeManager\AdvisorController@restore')->name('restore');
        Route::get('/{id}/delete','FrontEnd\OfficeManager\AdvisorController@delete')->name('delete');
    });
});

/*************************************************************************************************
| Admin Panel || All Routes
**************************************************************************************************/
require('web_admin.php');

  





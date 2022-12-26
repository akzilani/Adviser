<?php


/*************************************************************************************************
| Admin Panel || All Routes
**************************************************************************************************/

use Illuminate\Support\Facades\Route;

/*********************
 * Admin Login Area
 *********************/
Route::prefix('admin')->name('admin.')->group(function(){
    
    Route::get('/','BackEnd\Auth\LoginController@showLoginForm');
    Route::get('/login','BackEnd\Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login','BackEnd\Auth\LoginController@login');
    Route::get('/password-reset','BackEnd\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password-reset','BackEnd\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password-reset-form','BackEnd\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/update','BackEnd\Auth\ResetPasswordController@reset')->name('password.update');
});

/*******************
 * Admin Panel
 *******************/
Route::middleware(["auth:admin"])->group(function(){

    /*************************
     * Admin Manage Part
     * **********************/
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::get('dashboard/', 'BackEnd\Auth\LoginController@showDashboard')->name('dashboard');
        Route::get('/logout','BackEnd\Auth\LoginController@logout')->name('logout');
        Route::get('activity-log','BackEnd\AdminController@ActivityLog')->name('activity_log');
        Route::post('delete/activity-log','BackEnd\AdminController@deleteActivity')->name('activity_log_delete');


        Route::get('/list','BackEnd\AdminController@index')->name('list');
        Route::get('/create','BackEnd\AdminController@create')->name('create');
        Route::post('/create','BackEnd\AdminController@store');
        Route::get('/{id}/view','BackEnd\AdminController@showProfile')->name('profile');
        Route::get('/{id}/edit','BackEnd\AdminController@edit')->name('edit');
        Route::get('/{id}/archive','BackEnd\AdminController@archive')->name('archive');

        Route::get('/archive-list','BackEnd\AdminController@archiveList')->name('archive_list');
        Route::get('/{id}/restore','BackEnd\AdminController@restore')->name('restore');

        Route::get('/monitoring','BackEnd\AdminController@monitoringList')->name('monitoring');

        // Website Settings
        Route::get('/website/setting','BackEnd\WebsiteSettingsController@create')->name('website.setting');
        Route::post('/website/setting','BackEnd\WebsiteSettingsController@store');
    });

    Route::prefix('dashboard')->group(function(){
        
        Route::get('visitor', 'BackEnd\VisitorController@index')->name('visitor');
        /***********************
         * Advisor
         **********************/
        Route::prefix('advisor')->name('advisor.')->group(function(){
            Route::get('/list','BackEnd\AdvisorController@index')->name('list');
            Route::get('/missing-info-list','BackEnd\AdvisorController@missingInfoList')->name('missing_info_list');
            Route::get('/import','BackEnd\AdvisorController@showImport')->name('import');
            Route::post('/import','BackEnd\AdvisorController@import');
            Route::get('/deleted-list','BackEnd\AdvisorController@deletedAdvisorList')->name('archived_list');
            Route::get('/filter-list/{type?}/{type_value?}','BackEnd\AdvisorController@filterAdvisor')->name('filter_list');
            Route::get('/billing','BackEnd\AdvisorController@advisorBillingList')->name('billing_list');
            Route::get('/{id}/view-billing','BackEnd\AdvisorController@advisorBillingView')->name('billing_view');
            Route::get('/{id}/edit-billing','BackEnd\AdvisorController@advisorBillingEdit')->name('billing_edit');
            Route::post('/{id}/edit-billing','BackEnd\AdvisorController@advisorBillingSave');

            // Promotional
            Route::get('promotional-list', 'BackEnd\AdvisorController@advisorPromotionalList')->name('promotional_list');
            Route::get('promotional-create', 'BackEnd\AdvisorController@advisorPromotionalCreate')->name('promotional_create');
            Route::post('promotional-create', 'BackEnd\AdvisorController@advisorPromotionalStore');
            Route::get('{id}/promotional-edit', 'BackEnd\AdvisorController@advisorPromotionalEdit')->name('promotional_edit');
            Route::get('{id}/promotional-delete', 'BackEnd\AdvisorController@advisorPromotionalDelete')->name('promotional_delete');

            //Advisor
            Route::get('/create','BackEnd\AdvisorController@create')->name('create');
            Route::post('/create','BackEnd\AdvisorController@store');
            Route::get('/{id}/dashboard','BackEnd\AdvisorController@dashboard')->name('view');
            Route::get('/{id}/view-postcode','BackEnd\AdvisorController@viewPostcodes')->name('view-postcode');
            Route::get('/{id}/edit','BackEnd\AdvisorController@edit')->name('edit');
            Route::get('/{id}/change-password','BackEnd\AdvisorController@changePasswordPage')->name('change_password');
            Route::post('/{id}/change-password','BackEnd\AdvisorController@changePassword');
            Route::get('/{id}/assign-under-officemanager', "BackEnd\AdvisorController@assignOfficeManagerPage")->name('assign_office_manager');
            Route::post('/{id}/assign-under-officemanager', "BackEnd\AdvisorController@assignOfficeManager");
            Route::get('/{id}/unassign-officemanager', "BackEnd\AdvisorController@unAssignOfficeManager")->name("unassign_office_manager");
            Route::get('/{id}/match-rating','BackEnd\AdvisorController@viewMatchRating')->name('view_march_rating');
            Route::get('/{id}/{subscribe}/subscribe','BackEnd\AdvisorController@subscribe')->name('subscribe');
            Route::get('/{id}/archive','BackEnd\AdvisorController@archive')->name('archive');
            Route::get('/{id}/restore','BackEnd\AdvisorController@restore')->name('restore');
            Route::get('/{id}/delete','BackEnd\AdvisorController@delete')->name('delete');

            Route::get('/{id}/email/send-verification-link','BackEnd\AdvisorController@sendVerificationEmail')->name('send_email_verification');
            Route::get('/{id}/email/verify','BackEnd\AdvisorController@emailVerify')->name('make_email_verify');
        });

        /*****************
         * Office Manager
         *****************/
        Route::prefix("office-manager")->name("office_manager.")->group(function(){
            Route::get("list", "BackEnd\OfficeManagerController@index")->name("list");
            Route::get("create", "BackEnd\OfficeManagerController@create")->name("create");
            Route::post("create", "BackEnd\OfficeManagerController@store");
            Route::get("{id}/edit", "BackEnd\OfficeManagerController@edit")->name("edit");
            Route::get('/{id}/{subscribe}/subscribe','BackEnd\OfficeManagerController@subscribe')->name('subscribe');
            Route::get("{id}/view-billing", "BackEnd\OfficeManagerController@viewBilingInfo")->name("view_billing");
             Route::get('/{id}/archive','BackEnd\OfficeManagerController@archive')->name('archive');
            Route::get('/deleted-list','BackEnd\OfficeManagerController@archivelist')->name('archived_list');
            Route::get('/{id}/restore','BackEnd\OfficeManagerController@restore')->name('restore');
            Route::get('/{id}/delete','BackEnd\OfficeManagerController@delete')->name('delete');
        });

        /**************
         * Lead
         *************/
        Route::prefix('lead')->name('lead.')->group(function(){
            Route::get('/list','BackEnd\LeadController@index')->name('list');
            Route::get('/search-locally', 'BackEnd\LeadController@searchLocally')->name('search_locally');
            Route::get('/match-me', 'BackEnd\LeadController@matchMe')->name('match_me');
            Route::get('/create','BackEnd\LeadController@create')->name('create');
            Route::post('/create','BackEnd\LeadController@store');
            Route::get('/{id}/view','BackEnd\LeadController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\LeadController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\LeadController@archive')->name('archive');
            Route::get('/deleted-list','BackEnd\LeadController@deletedList')->name('archive_list');
            Route::get('/{id}/delete','BackEnd\LeadController@delete')->name('delete');
            Route::get('/{id}/restore','BackEnd\LeadController@restore')->name('restore');
            Route::get('/{lead_id}/assign-auction','BackEnd\LeadController@assignIntoAuction')->name('assign_into_auction');
        });

        /**************
         * Auction Lead
         *************/
        Route::prefix('auction')->name('auction.')->group(function(){
            Route::get('/list','BackEnd\AuctionController@index')->name('list');
            Route::get('/deleted-list','BackEnd\AuctionController@archiveList')->name('archive_list');
            Route::get('/accept-condition-list','BackEnd\AuctionController@acceptConditionList')->name('accept_list');

            Route::get('/search-locally', 'BackEnd\AuctionController@searchLocally')->name('search_locally');
            Route::get('/match-me', 'BackEnd\AuctionController@matchMe')->name('match_me');
            Route::get('/create','BackEnd\AuctionController@create')->name('create');
            Route::post('/create','BackEnd\AuctionController@store');
            Route::get('/{id}/view','BackEnd\AuctionController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\AuctionController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\AuctionController@archive')->name('archive');

            Route::get('/{id}/delete','BackEnd\AuctionController@delete')->name('delete');
            Route::get('/{id}/restore','BackEnd\AuctionController@restore')->name('restore');
        });

        /**
         * Match Rating
         */
        Route::prefix('match-rating')->name('match_rating.')->group(function(){
            Route::get('/list','BackEnd\MatchRatingController@index')->name('list');
            Route::get('/create','BackEnd\MatchRatingController@create')->name('create');
            Route::post('/create','BackEnd\MatchRatingController@store');
            Route::get('/{id}/edit','BackEnd\MatchRatingController@edit')->name('edit');
            Route::get('/{id}/delete','BackEnd\MatchRatingController@delete')->name('delete');
            Route::get('re-generate','BackEnd\MatchRatingController@reGenerate')->name('re_generate');
        });

        /********************
         * Advisor Question
         ********************/
        Route::prefix('advisor-question')->name('advisorQuestion.')->group(function(){
            Route::get('/list','BackEnd\AdvisorQuestionController@index')->name('list');
            Route::get('/create','BackEnd\AdvisorQuestionController@create')->name('create');
            Route::post('/create','BackEnd\AdvisorQuestionController@store');
            Route::get('/{id}/view','BackEnd\AdvisorQuestionController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\AdvisorQuestionController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\AdvisorQuestionController@archive')->name('archive');
        });

        /********************
         * Advisor Interview
         ********************/
        Route::prefix('interview-question')->name('interview_question.')->group(function(){
            Route::get('/list','BackEnd\InterviewController@index')->name('list');
            Route::get('/create','BackEnd\InterviewController@create')->name('create');
            Route::post('/create','BackEnd\InterviewController@store');
            
            Route::get('/{id}/view','BackEnd\InterviewController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\InterviewController@edit')->name('edit');
            Route::get('/{id}/delete','BackEnd\InterviewController@delete')->name('delete');

            Route::get('/answer-list','BackEnd\InterviewController@answerList')->name('answer_list');
            Route::get('/answer-list/{id}/edit','BackEnd\InterviewController@showAnsEditPage')->name('answer_edit');
            Route::post('/answer-list/{id}/edit','BackEnd\InterviewController@answerUpdate');
            Route::get('/answer-list/{id}/delete','BackEnd\InterviewController@deleteAnswer')->name('answer_delete');

        });

        /**************
         * Advisor Type
         *************/
        Route::prefix('advisor-type')->name('advisorType.')->group(function(){
            Route::get('/list','BackEnd\AdvisorTypeController@index')->name('list');
            Route::get('/create','BackEnd\AdvisorTypeController@create')->name('create');
            Route::post('/create','BackEnd\AdvisorTypeController@store');
            Route::get('/{id}/view','BackEnd\AdvisorTypeController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\AdvisorTypeController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\AdvisorTypeController@archive')->name('archive');
        });
        
        /**************
         * Author List
         *************/
        Route::prefix('author-list')->name('authorList.')->group(function(){
            Route::get('/list','BackEnd\AuthorListController@index')->name('list');
            Route::get('/create','BackEnd\AuthorListController@create')->name('create');
            Route::post('/create','BackEnd\AuthorListController@store');
            Route::get('/{id}/view','BackEnd\AuthorListController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\AuthorListController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\AuthorListController@archive')->name('archive');
        });


        /**************
         * Profession
         *************/
        Route::prefix('profession')->name('profession.')->group(function(){
            Route::get('/list','BackEnd\ProfessionController@index')->name('list');
            Route::get('/create','BackEnd\ProfessionController@create')->name('create');
            Route::post('/create','BackEnd\ProfessionController@store');
            Route::get('/{id}/view','BackEnd\ProfessionController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\ProfessionController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\ProfessionController@archive')->name('archive');
        });
        

        /**************
         * Firm Size
         *************/
        Route::prefix('firm-size')->name('firmSize.')->group(function(){
            Route::get('/list','BackEnd\FirmSizeController@index')->name('list');
            Route::get('/create','BackEnd\FirmSizeController@create')->name('create');
            Route::post('/create','BackEnd\FirmSizeController@store');
            Route::get('/{id}/view','BackEnd\FirmSizeController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\FirmSizeController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\FirmSizeController@archive')->name('archive');
        });

        /**************
         * Fund Size
         *************/
        Route::prefix('fund-size')->name('fundSize.')->group(function(){
            Route::get('/list','BackEnd\FundSizeController@index')->name('list');
            Route::get('/create','BackEnd\FundSizeController@create')->name('create');
            Route::post('/create','BackEnd\FundSizeController@store');
            Route::get('/{id}/view','BackEnd\FundSizeController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\FundSizeController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\FundSizeController@archive')->name('archive');
        });

        /*****************
         * Service Offer
         ****************/
        Route::prefix('service-offer')->name('serviceOffer.')->group(function(){
            Route::get('/list','BackEnd\ServiceOfferController@index')->name('list');
            Route::get('/create','BackEnd\ServiceOfferController@create')->name('create');
            Route::post('/create','BackEnd\ServiceOfferController@store');
            Route::get('/{id}/view','BackEnd\ServiceOfferController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\ServiceOfferController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\ServiceOfferController@archive')->name('archive');
        });

        /**************
         * Primary Region
         *************/
        Route::prefix('primary-reason')->name('primaryReason.')->group(function(){
            Route::get('/list','BackEnd\PrimaryReasonController@index')->name('list');
            Route::get('/create','BackEnd\PrimaryReasonController@create')->name('create');
            Route::post('/create','BackEnd\PrimaryReasonController@store');
            Route::get('/{id}/view','BackEnd\PrimaryReasonController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\PrimaryReasonController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\PrimaryReasonController@archive')->name('archive');
        });

        /**************
         *  Primary Subscription Locations
         *************/
        Route::prefix('subscribe-primary-reason')->name('subscribePrimaryReason.')->group(function(){
            Route::get('/list','BackEnd\SubscriptionPrimaryReasonController@index')->name('list');
            Route::get('/create','BackEnd\SubscriptionPrimaryReasonController@create')->name('create');
            Route::post('/create','BackEnd\SubscriptionPrimaryReasonController@store');
            Route::get('/{id}/view','BackEnd\SubscriptionPrimaryReasonController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\SubscriptionPrimaryReasonController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\SubscriptionPrimaryReasonController@archive')->name('archive');
        });

        /***********************
         * Location Postcode
         **********************/
        Route::prefix('post-code')->name('postcode.')->group(function(){
            Route::get('/list','BackEnd\LocationPostCodeController@index')->name('list');
            Route::get('/deleted-list','BackEnd\LocationPostCodeController@archiveList')->name('deleted_list');
            Route::get('/create','BackEnd\LocationPostCodeController@create')->name('create');
            Route::post('/create','BackEnd\LocationPostCodeController@store');
            Route::get('/{id}/view','BackEnd\LocationPostCodeController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\LocationPostCodeController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\LocationPostCodeController@archive')->name('archive');
            Route::get('/{id}/restore','BackEnd\LocationPostCodeController@restore')->name('restore');
        });

        /***********************
         * Subscrive Postcode
         * PostCode Cover Area
         **********************/
        Route::prefix('subscribe-postcode')->name('subscribePostcode.')->group(function(){
            Route::get('/list','BackEnd\SubscribePostCodeController@index')->name('list');
            Route::get('/create','BackEnd\SubscribePostCodeController@create')->name('create');
            Route::post('/create','BackEnd\SubscribePostCodeController@store');
            Route::get('/{id}/view','BackEnd\SubscribePostCodeController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\SubscribePostCodeController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\SubscribePostCodeController@archive')->name('archive');
        });

        /*****************
         * Subscription
         *****************/
        Route::prefix('subscription')->name('subscription.')->group(function(){
            Route::get('/list','BackEnd\SubscriptionController@index')->name('list');
            Route::get('/create','BackEnd\SubscriptionController@create')->name('create');
            Route::post('/create','BackEnd\SubscriptionController@store');
            Route::get('/{id}/view','BackEnd\SubscriptionController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\SubscriptionController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\SubscriptionController@archive')->name('archive');
        });
        

        /**************
         * Testimonial
         *************/
        Route::prefix('testimonial')->name('testimonial.')->group(function(){
            Route::get('/list','BackEnd\TestimonialController@index')->name('list');
            Route::get('/create','BackEnd\TestimonialController@create')->name('create');
            Route::post('/create','BackEnd\TestimonialController@store');
            Route::get('/{id}/view','BackEnd\TestimonialController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\TestimonialController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\TestimonialController@archive')->name('archive');
        });

        /**************************
         * Communication / Message
         **************************/
        Route::prefix('communication')->name('communication.')->group(function(){
            Route::get('/list','BackEnd\CommunicationController@index')->name('list');
            Route::get('/create','BackEnd\CommunicationController@create')->name('create');
            Route::post('/create','BackEnd\CommunicationController@store');
            Route::get('/{id}/edit','BackEnd\CommunicationController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\CommunicationController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\CommunicationController@archive')->name('archive');
        });

        /**************************
         * Blog Post
         **************************/
        Route::prefix('blog')->name('blog.')->group(function(){
            Route::get('/list','BackEnd\BlogController@index')->name('list');
            Route::get('/create','BackEnd\BlogController@create')->name('create');
            Route::post('/create','BackEnd\BlogController@store');
            Route::get('/{id}/edit','BackEnd\BlogController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\BlogController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\BlogController@archive')->name('archive');
        });

        /**************************
         * Advisor Blog Post
         **************************/
        Route::prefix('advisor-blog')->name('advisor_blog.')->group(function(){
            Route::get('/list','BackEnd\AdvisorBlogController@index')->name('list');
            Route::get('/create','BackEnd\AdvisorBlogController@create')->name('create');
            Route::post('/create','BackEnd\AdvisorBlogController@store');
            Route::get('/{id}/edit','BackEnd\AdvisorBlogController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\AdvisorBlogController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\AdvisorBlogController@archive')->name('archive');
        });

        /**************************
         * Tips & Guides
         **************************/
        Route::prefix('tips-guides')->name('tips_guides.')->group(function(){
            Route::get('/list','BackEnd\TipsGuidesController@index')->name('list');
            Route::get('/create','BackEnd\TipsGuidesController@create')->name('create');
            Route::post('/create','BackEnd\TipsGuidesController@store');
            Route::get('/{id}/edit','BackEnd\TipsGuidesController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\TipsGuidesController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\TipsGuidesController@archive')->name('archive');
        });

        /**************************
         * Enquires
         **************************/
        Route::prefix('enquires')->name('enquires.')->group(function(){
            Route::get('/list','BackEnd\EnquiresController@index')->name('list');
            Route::get('/{id}/view','BackEnd\EnquiresController@view')->name('view');
            Route::get('/{id}/delete','BackEnd\EnquiresController@delete')->name('delete');
            
        });

        /**
         * Terms & Conditiont
         */
        Route::prefix('terms-and-condition')->name('terms_&_condition.')->group(function(){
            Route::get('/list', 'BackEnd\TermsAndConditionController@index')->name('list');
            Route::get('create', 'BackEnd\TermsAndConditionController@create')->name('create');
            Route::post('create', 'BackEnd\TermsAndConditionController@store');
            Route::get('/{id}/view','BackEnd\TermsAndConditionController@view')->name('view');
            Route::get('/{id}/edit','BackEnd\TermsAndConditionController@edit')->name('edit');
            Route::get('/{id}/archive','BackEnd\TermsAndConditionController@archive')->name('archive');
            Route::get('/{id}/archive','BackEnd\TermsAndConditionController@archive')->name('archive');
        });

        /**************************
         * Quick links
         **************************/
        Route::prefix('quick-link')->name('quick_link.')->group(function(){
            Route::get('/list','BackEnd\QuickLinkController@index')->name('list');
            Route::get('/create','BackEnd\QuickLinkController@create')->name('create');
            Route::post('/create','BackEnd\QuickLinkController@store');
            Route::get('/{id}/edit','BackEnd\QuickLinkController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\QuickLinkController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\QuickLinkController@archive')->name('archive');
        });

        /**************************
         * Advisor Quick links
         **************************/
        Route::prefix('advisor-quick-link')->name('advisor_quick_link.')->group(function(){
            Route::get('/list','BackEnd\AdvisorQuickLinkController@index')->name('list');
            Route::get('/create','BackEnd\AdvisorQuickLinkController@create')->name('create');
            Route::post('/create','BackEnd\AdvisorQuickLinkController@store');
            Route::get('/{id}/edit','BackEnd\AdvisorQuickLinkController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\AdvisorQuickLinkController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\AdvisorQuickLinkController@archive')->name('archive');
        });

        /**************************
         * Page Section
         **************************/
        Route::prefix('page')->name('page.')->group(function(){
            Route::get('/list','BackEnd\PageController@index')->name('list');
            Route::get('/create','BackEnd\PageController@create')->name('create');
            Route::post('/create','BackEnd\PageController@store');
            Route::get('/{id}/edit','BackEnd\PageController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\PageController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\PageController@archive')->name('archive');
        });

        /**************************
         * FAQ Section
         **************************/
        Route::prefix('FAQ')->name('faq.')->group(function(){
            Route::get('/list','BackEnd\FAQController@index')->name('list');
            Route::get('/create','BackEnd\FAQController@create')->name('create');
            Route::post('/create','BackEnd\FAQController@store');
            Route::get('/{id}/edit','BackEnd\FAQController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\FAQController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\FAQController@archive')->name('archive');
        });

        /**************************
         * Social Media Section
         **************************/
        Route::prefix('social-media')->name('social_media.')->group(function(){
            Route::get('/list','BackEnd\SocialMediaController@index')->name('list');
            Route::get('/create','BackEnd\SocialMediaController@create')->name('create');
            Route::post('/create','BackEnd\SocialMediaController@store');
            Route::get('/{id}/edit','BackEnd\SocialMediaController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\SocialMediaController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\SocialMediaController@archive')->name('archive');
        });

        /**************************
         * Email
         **************************/
        Route::prefix('email')->name('email.')->group(function(){
            Route::get('/send','BackEnd\EmailController@sendMailPage')->name('send');
            Route::post('/send','BackEnd\EmailController@sendMail');
          
            Route::get('/configure','BackEnd\EmailController@configurePageShow')->name('configuration');
            Route::post('/configure','BackEnd\EmailController@saveConfigure');

            Route::get('/template','BackEnd\EmailController@templateList')->name('template');
            Route::get('/template/create','BackEnd\EmailController@templateCreate')->name("template.create");
            Route::post('/template/create','BackEnd\EmailController@templateSave');
            Route::get('/template/{id}/edit','BackEnd\EmailController@templateEdit')->name("template.edit");
            Route::get('/template/{id}/delete','BackEnd\EmailController@templateDelete')->name("template.delete");
        });
        
        /**************************
         * Fetchfy Configuration
         **************************/
        Route::prefix('fetchfy-configuration')->name('fetchfy_configuration.')->group(function(){
            Route::get('/list','BackEnd\FetchfyConfigurationController@index')->name('list');
            Route::get('/create','BackEnd\FetchfyConfigurationController@create')->name('create');
            Route::post('/create','BackEnd\FetchfyConfigurationController@store');
            Route::get('/{id}/edit','BackEnd\FetchfyConfigurationController@edit')->name('edit');
            Route::get('/{id}/view','BackEnd\FetchfyConfigurationController@view')->name('view');
            Route::get('/{id}/archive','BackEnd\FetchfyConfigurationController@archive')->name('archive');
        });

        /**
         * User Permission & Group Access
         */
        Route::prefix('group/')->name('group.')->group(function(){
            Route::get('/list', 'BackEnd\AccessController@index')->name('list');
            Route::get('/create', 'BackEnd\AccessController@create')->name('create');
            Route::post('/create', 'BackEnd\AccessController@store');
            Route::get('/{id}/edit', 'BackEnd\AccessController@edit')->name('edit');
            Route::get('/{id}/permission', 'BackEnd\AccessController@permission')->name('permission');
            Route::post('/{id}/permission', 'BackEnd\AccessController@storePermission');
            Route::get('/{id}/delete', 'BackEnd\AccessController@delete')->name('delete');
        });
    });

});
<?php

namespace App\Providers;

use App\Events\AuctionBid;
use App\Events\AuctionCancel;
use App\Events\AuctionCreated;
use App\Events\LeadAssign;
use App\Events\LeadInvitation;
use App\Events\Subscribe;
use App\Listeners\AuctionCreateNotification;
use App\Listeners\SendAuctionCancelEmail;
use App\Listeners\SendLeadAssignEmail;
use App\Listeners\SendLeadInvitationEmail;
use App\Listeners\SendLowerBidEmail;
use App\Listeners\SendNewBidEmail;
use App\Listeners\SendSignupEmail;
use App\Listeners\SendTermsAndConditionsEmail;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendWelcomeEmail::class,
            SendEmailVerificationNotification::class,
        ],
        Subscribe::class => [
            SendSignupEmail::class,
            SendTermsAndConditionsEmail::class,
        ],
        LeadAssign::class => [
            SendLeadAssignEmail::class,
        ],
        LeadInvitation::class => [
            SendLeadInvitationEmail ::class
        ],        
        AuctionCreated::class => [
            AuctionCreateNotification::class,
        ],
        AuctionBid::class => [
            SendNewBidEmail::class,
            SendLowerBidEmail::class,
        ],
        AuctionCancel::class=> [
            SendAuctionCancelEmail::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

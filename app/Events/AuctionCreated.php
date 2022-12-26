<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionCreated
{
    /**
     * Auction Invitation Email
     */
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction, $advisors, $active_buy_out;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($auction, $active_buy_out = false)
    {
        $this->auction = $auction;
        $this->active_buy_out = $active_buy_out;
        $this->advisors = $this->getAdvisors($auction->primary_region_id, $auction->profession_id);
        // $this->advisors = $this->getTestAdvisor();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * Get Advisor List Under Primary reasons
     */
    protected function getAdvisors( array $primary_reason, $profession_id){
        return User::where('status', 'active')
            ->where("profession_id", $profession_id)
            ->where(function($qry)use($primary_reason){
                $i = 0;
                foreach($primary_reason as $reason){
                    if($i == 0){
                        $qry->where('primary_region_id', $reason);
                        $i++;
                    }else{
                        $qry->orWhere('primary_region_id', $reason);
                    }
                }   
            })->get();
    }

    protected function getTestAdvisor(){
        return User::where('email', 'shajushahjalal@gmail.com')->get();
    }
}

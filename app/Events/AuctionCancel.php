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

class AuctionCancel
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction, $advisors;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($auction)
    {
        $this->auction = $auction;
        $this->advisors = $this->getAdvisors($auction->primary_region_id);
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
    protected function getAdvisors( array $primary_reason){
        return User::where('status', 'active')
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
}

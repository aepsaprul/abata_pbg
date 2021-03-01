<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PbgAntrianDesainStatusDisplay implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $desain_nomor;
    public $status;
    public $nama_desain;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($desain_nomor,$status,$nama_desain)
    {
        $this->desain_nomor = $desain_nomor;
        $this->status = $status;
        $this->nama_desain = $nama_desain;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['desain-status'];
    }

    public function broadcastAs()
    {
        return 'desain-status-event';
    }
}

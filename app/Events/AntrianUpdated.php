<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Payload with keys: nomor, loket, status, sesi
     * @var array
     */
    public $antrian;

    /**
     * Create a new event instance.
     *
     * @param array $antrian
     * @return void
     */
    public function __construct(array $antrian)
    {
        $this->antrian = $antrian;
    }

    /**
     * Get the channels the event should broadcast on.
     * Public channel so visitor display doesn't need auth.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('antrian.public');
    }

    /**
     * Data to broadcast to clients
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'antrian' => $this->antrian,
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'antrian.updated';
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\device;

class DeviceSessionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $device;
    public $zoom;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(device $device, $zoom)
    {
        $this->device = $device;
        $this->zoom = $zoom;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('device-session.' . $this->zoom->code);
    }

    public function broadcastWith()
    {
        $newdevice = $this->zoom->devices()->where('zoom_id', $this->zoom->id)
            ->where('device_id', $this->device->id)->first();
        return
            [
                'id' => $this->device->id,
                'deviceName' => $this->device->deviceName,
                'deviceID' => $this->device->deviceID,
                'state' => $this->device->state,
                'pivot' => $newdevice->pivot,
                'serial' => $this->device->serial,
                'os_version' => $this->device->os_version,
                'battery' => $this->device->battery
            ];
    }
}

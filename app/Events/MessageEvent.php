<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class MessageEvent implements ShouldBroadcastNow
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $message;
  public $receiverId;
  public $sendDate;
  public $senderId;
  public $senderImage;

  /**
   * Create a new event instance.
   */
  public function __construct($message, $receiverId, $sendDate, $senderId = null, $senderImage = null)
  {
    $this->message = $message;
    $this->receiverId = $receiverId;
    $this->sendDate = $sendDate;
    $this->senderId = $senderId;
    $this->senderImage = $senderImage;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return array<int, \Illuminate\Broadcasting\Channel>
   */
  public function broadcastOn(): array
  {
    return [
      new PrivateChannel('message.' .$this->receiverId),
    ];
  }

  public function broadcastWith(): array
  {
    return [
      'message' => $this->message,
      'receiver_id' => $this->receiverId,
      'sender_id' => $this->senderId ?? Auth::user()->id,
      'sender_image' => $this->senderImage ?? asset(Auth::user()->image),
      'send_date' => $this->sendDate,
    ];
  }
}

<?php

namespace App\Events;

 use Illuminate\Broadcasting\InteractsWithSockets;
 use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $response_message_html;
    public $message;

    public function __construct($response_message_html,$message)
    {
        $this->message = $message;
        $this->response_message_html = $response_message_html;

    }
    public function broadcastOn()
    {
        return ['conversation_' . $this->message['conversation_id']];
    }
    public function broadcastAs()
    {
        return 'new-message';
    }

}

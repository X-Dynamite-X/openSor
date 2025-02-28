<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewConversationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation ,$newConversationHtml;

    public function __construct($conversation,$newConversationHtml)
    {
        $this->conversation = $conversation;
        $this->newConversationHtml = $newConversationHtml;
    }
    public function broadcastOn()
    {
        return ['user_' . $this->conversation['user_two_id']];
    }

    public function broadcastAs()
    {
        return 'add-conversation';
    }
    public function broadcastWith()
    {
        return [
            'conversation' => $this->conversation,
            'new_conversation_html' => $this->newConversationHtml,
        ];
    }
}

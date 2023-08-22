<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use App\Models\Recipient;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Participant;
use App\Models\Message;

class MessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $other_user = $this->message->conversation->participants()
        ->where('user_id','<>',$this->message->user_id)
        // ->where('user_id','<>',Auth::id())
        ->first();

        // print_r($other_user->id);die;

        // return new PresenceChannel('Messanger-'.$this->message->conversation_id);
        return new PresenceChannel('Messanger.'.$other_user->id);
    }

    public function broadcastAs(){
        return 'new-message';
    }
}

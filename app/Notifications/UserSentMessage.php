<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;


class UserSentMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;
    public $sender;

    public function __construct($sender, $message)
    {
        $this->sender = $sender;
        $this->message = $message;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'message' => $this->message->body ?? '(no content)',
            'message_id' => $this->message->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'sender_id' => $this->sender->id,
            'sender_name' => $this->sender->name,
            'message' => $this->message->body ?? '(no content)',
            'message_id' => $this->message->id,
        ]);
    }
}

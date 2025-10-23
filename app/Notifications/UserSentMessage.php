<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;
use App\Models\Message;

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

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable)
    {
        return [
            'sender_id' => $sender->id,
            'sender_name' => $sender->name,
            'message' => $message->body ?? '(no content)',
            'message_id' => $message->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'sender_id' => $sender->id,
            'sender_name' => $sender->name,
            'message' => $message->body ?? '(no content)',
            'message_id' => $message->id,
        ]);
    }
}

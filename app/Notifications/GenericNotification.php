<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class GenericNotification extends Notification
{

    use Queueable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'url' => $this->data['url'] ?? null,
            'action_taken_by' => user()->name ?? 'N/A',
            'action_taken_at' => now(),
            'user_email' => user()->email ?? 'N/A',
            'instance' => user()->instance() ?? 'N/A',
        ];
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'url' => $this->data['url'] ?? null,
        ]);
    }



    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->data['title'])
            ->line($this->data['message'])
            ->action('View Details', $this->data['url'] ?? url('/'));
    }
}

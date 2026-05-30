<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectFlowNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $url;

    public function __construct(
        $title,
        $message,
        $url
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [

            'title' => $this->title,

            'message' => $this->message,

            'url' => $this->url,

        ];
    }
}
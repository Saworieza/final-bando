<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class NewUserPendingApproval extends Notification
{
    use Queueable;

    protected User $pendingUser;

    public function __construct(User $pendingUser)
    {
        $this->pendingUser = $pendingUser;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New User Pending Approval')
            ->line("{$this->pendingUser->name} has registered as {$this->pendingUser->getRoleNames()->first()} and is awaiting approval.")
            ->action('View Users', url('/dashboard'))
            ->line('You can approve or change their role in your admin dashboard.');
    }
}

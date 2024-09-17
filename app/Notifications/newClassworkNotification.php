<?php

namespace App\Notifications;

use App\Models\Classwork;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class newClassworkNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Classwork $classwork)
    {
        //
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        $classwork = $this->classwork;
        $content = __(':name posted a new :type :title', [
            'name' => $classwork->user->name,
            'type' => __($classwork->type),
            'title' => $classwork->title,
        ]);
        return new BroadcastMessage([
            'title' => __('New :type', [
                'type' => $classwork->type,
            ]),
            'body' => $content,
            'image' => Storage::disk('public')->url($classwork->user->profile->user_img_path),
            'link' => route('classrooms.classworks.show', [$classwork->classroom_id, $classwork->id]),
            'classwork_id' => $classwork->id,
        ]);
    }
    public function toDatabase(object $notifiable): DatabaseMessage
    {
        $classwork = $this->classwork;
        $content = __(':name posted a new :type :title', [
            'name' => $classwork->user->name,
            'type' => __($classwork->type),
            'title' => $classwork->title,
        ]);
        return new DatabaseMessage([
            'title' => __('New :type', [
                'type' => $classwork->type,
            ]),
            'body' => $content,
            'image' => Storage::disk('public')->url($classwork->user->profile->user_img_path),
            'link' => route('classrooms.classworks.show', [$classwork->classroom_id, $classwork->id]),
            'classwork_id' => $classwork->id,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

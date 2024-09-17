<?php

namespace App\Listeners;

use App\Events\ClassworkCommented;
use App\Notifications\addCommentOnClassworkNotification;
use App\Notifications\commentOnClasswork;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class addCommentOnClasswork
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ClassworkCommented $event): void
    {
        Notification::send($event->comment->classwork->users, new addCommentOnClassworkNotification($event->comment));
    }
}

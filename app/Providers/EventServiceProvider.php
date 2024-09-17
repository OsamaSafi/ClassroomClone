<?php

namespace App\Providers;

use App\Events\ClassworkCommented;
use App\Events\ClassworkCreated;
use App\Events\ClassworkSubmission;
use App\Listeners\addCommentOnClasswork;
use App\Listeners\addSubmissionOnClasswork;
use App\Listeners\PostInClassroomStream;
use App\Listeners\PostInClassworkCommentStream;
use App\Listeners\sendNotificationToAssignedStudents;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ClassworkCreated::class => [
            PostInClassroomStream::class,
            sendNotificationToAssignedStudents::class
        ],
        ClassworkCommented::class => [
            addCommentOnClasswork::class,
            PostInClassworkCommentStream::class
        ],
        ClassworkSubmission::class => [
            addSubmissionOnClasswork::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

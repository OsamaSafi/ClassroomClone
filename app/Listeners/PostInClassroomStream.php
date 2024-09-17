<?php

namespace App\Listeners;

use App\Models\Stream;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostInClassroomStream
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
    public function handle(object $event): void
    {
        $content = __(':name posted a new :type :title', [
            'name' => $event->classwork->user->name,
            'type' => $event->classwork->type,
            'title' => $event->classwork->title
        ]);
        Stream::create([
            'user_id' => $event->classwork->user_id,
            'classroom_id' => $event->classwork->classroom_id,
            'content' => $content,
            'link' => route('classrooms.classworks.show', [$event->classwork->classroom_id, $event->classwork->id]),
        ]);
    }
}

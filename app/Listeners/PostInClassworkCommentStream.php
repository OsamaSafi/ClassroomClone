<?php

namespace App\Listeners;

use App\Models\Stream;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PostInClassworkCommentStream
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
        $content = __(':name commented (:content) in :type :title', [
            'name' => $event->comment->classwork->user->name,
            'type' => $event->comment->classwork->type,
            'title' => $event->comment->classwork->title,
            'content' => $event->comment->content
        ]);
        Stream::create([
            'user_id' => $event->comment->classwork->user_id,
            'classroom_id' => $event->comment->classwork->classroom_id,
            'content' => $content,
            'link' => route('classrooms.classworks.show', [$event->comment->classwork->classroom_id, $event->comment->classwork->id]),
        ]);
    }
}

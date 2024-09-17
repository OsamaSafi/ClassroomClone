<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('classroom.{id}', function ($user, $id) {
    return $user->classroom->where('id', '=', $id)->exists();
});


Broadcast::channel('chat-classroom-{id}', function ($user, $id) {
    // Ensure the user is authenticated and belongs to the classroom
    $classroom = $user->classrooms()->find($id);

    if ($classroom) {
        return ['id' => $user->id, 'name' => $user->name];
    }

    // Return false to trigger a 403 error if the user is not authorized
    return false;
});

<?php

use App\Events\StatusLiked;
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

Broadcast::channel('status-liked', function ($user, $id) {
    // return "Hello";
    return true;

    event(new StatusLiked('Hello World'));
});

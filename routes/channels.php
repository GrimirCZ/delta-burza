<?php

use App\Models\Messenger;
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

Broadcast::channel('App.Models.User.{id}', function($user, $id){
    return (int)$user->id === (int)$id;
});

Broadcast::channel('new_messenger.{receiver}', function($user, Messenger $receiver){
    return Auth::check() && $receiver->data['school_id'] == Auth::user()->school_id;
});

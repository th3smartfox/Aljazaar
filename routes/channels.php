<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id || $user->hasRole('admin'); // Assuming Spatie permission or similar admin check
});

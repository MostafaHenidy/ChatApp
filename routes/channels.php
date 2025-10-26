<?php

use App\Models\Conversation;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
Broadcast::channel('chat.{conversation_id}', function ($user, $conversationId) {
    $conversation = Conversation::findOrFail($conversationId);
    $participatIds = explode('and', $conversation->name);
    if (count($participatIds) !== 2) {
        return false;
    }
    $userId = (string) $user->id;
    if (in_array($userId, $participatIds)) {
        return true;
    }
    return false;
});
Broadcast::channel('presence-chat.{group_id}', function ($user, $groupId) {
    $group = Group::findOrFail($groupId);
    if (!$group) return false;
    if ($group->members->pluck('id')->contains($user->id)) {
        return ['id' => $user->id, 'name' => $user->name];
    }
    return false;
});

// Authorize private notification channel for the targeted user id
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

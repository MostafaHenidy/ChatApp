<?php

use App\Models\User;
use Laravolt\Avatar\Facade as Avatar;

function getAvatar($name)
{
    $user = User::where('name', $name)->first();

    if ($user && $user->getFirstMediaUrl('avatars')) {
        // Always returns a full public URL like /storage/8/18.png
        return $user->getFirstMediaUrl('avatars');
    }

    // Fallback: generate default avatar as base64
    return Avatar::create($name)->toBase64();
}

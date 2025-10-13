<?php

use App\Models\User;
use Laravolt\Avatar\Facade as Avatar;

function getAvatar($name)
{
    $user = User::where('name', $name)->first();

    if ($user && $user->getLastMedia('avatars')) {
        return $user->getLastMedia('avatars')->getUrl();
    }

    return Avatar::create($name)->toBase64();
}

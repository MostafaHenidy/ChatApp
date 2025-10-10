<?php

use Laravolt\Avatar\Facade as Avatar;

function getAvatar($name)
{
    return Avatar::create($name)->toBase64();
}

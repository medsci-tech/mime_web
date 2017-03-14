<?php

namespace App\Message\Facades;

use Illuminate\Support\Facades\Facade;


class MessageSender extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'message_sender';
    }
}
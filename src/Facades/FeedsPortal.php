<?php

namespace Cornatul\Feeds\Facades;

class FeedsPortal extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'feeds';
    }
}

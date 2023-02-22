<?php

namespace Cornatul\Feeds\Services;

class FeedPortal
{
    /** @var Application */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}

<?php

namespace Cornatul\Feeds\Console;

use Illuminate\Console\Command;

class SentimentConsole extends Command
{



    protected $signature = 'feeds:sentiment';

    protected $description = 'Extract the sentiment from the articles';

    public function handle(): void
    {
        $this->info('This is the feeds:sentiment command');
    }
}

<?php

namespace SePay\SePay\Commands;

use Illuminate\Console\Command;

class SePayCommand extends Command
{
    public $signature = 'laravel-sepay';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

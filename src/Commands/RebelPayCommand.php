<?php

namespace Rebel\RebelPay\Commands;

use Illuminate\Console\Command;

class RebelPayCommand extends Command
{
    public $signature = 'rebel-rebelpay';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

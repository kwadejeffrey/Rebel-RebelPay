<?php

namespace Rebel\RebelPay\Commands;

use Illuminate\Console\Command;

class RebelPayCommand extends Command
{
    public $signature = 'paystack';

    public $description = 'My command';

    public function handle(): int
    {
        // $this->comment('All done');
        if ($this->confirm('Do you mind giving us star on Github?')) {
            // ...
            $repoUrl = 'https://github.com/RebelNii/Rebel-RebelPay';

            if (PHP_OS_FAMILY == 'Darwin') {
                exec("open {$repoUrl}");
            }
            if (PHP_OS_FAMILY == 'Windows') {
                exec("start {$repoUrl}");
            }
            if (PHP_OS_FAMILY == 'Linux') {
                exec("xdg-open {$repoUrl}");
            }
        }

        return self::SUCCESS;
    }
}

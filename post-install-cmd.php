<?php

if (! isset($_ENV['CI']) && ! isset($_SERVER['CI'])) {
    $starRepo = readline('Thank you for installing the package! Would you like to star our GitHub repository? (Y/n): ');

    if (strtolower($starRepo) === 'y') {
        echo "Opening repository page...\n";
        exec('start https://github.com/RebelNii/Rebel-RebelPay');
    }
}

#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use JFastnacht\DiceRoller\Command\RollCommand as RollCommandAlias;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new RollCommandAlias());

try {
    $application->run();
} catch (Exception $e) {
    echo $e->getMessage();
}

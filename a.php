<?php

// declare(ticks=1);

// require __DIR__.'/HardCoreDebugLogger.php';
// HardCoreDebugLogger::register();

function foobar()
{
    $c = 1;
}

require __DIR__.'/b.php';

foobar();
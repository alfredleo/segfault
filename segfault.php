<?php
require __DIR__.'/HardCoreDebugLogger.php';
declare(ticks=1); // We need tick in this file
HardCoreDebugLogger::register();

function a()
{
    b();
}

function b()
{
    c();
}

function c()
{
    $a = 1 + 2;
    "" . (new Crash());
}

class Crash
{
    public function __tostring()
    {
        return "" . $this;
    }
}

a();

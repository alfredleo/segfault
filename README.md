# HardCore Debug Logger

[jump to usage](#user-content-usage)

## A bit of history

Sometimes, a segfaults happen, but you don't know where, and your PHP
installation does not have tools to find it. Or sometime, you think PHP is
hanging, but you don't know where. You may use xdebug, but you don't want to
click so many times on the "next call" button.

To addresses theses issues, I used to use this [hack](https://gist.github.com/lyrixx/17074868cdfabd4c783e).

The code is pretty small but it could appear really weird. Don't worry, I will
explain it.

1. We register a tick function. A tick is an event emitted by PHP when a very
low-level (tickable) statements is executed. This function will be executed on
each PHP Tick and will print the last executed line.

2. We tell PHP to fire an event for all possible tick.

3. Profit... Thanks to that, it's possible to find the last successfully
executed line.

But, what I did not know, is that it worked because of a [PHP
Bug](https://bugs.php.net/bug.php?id=77901): `declare(ticks=1)` is not supposed
to leak to other files. This has been fixed in PHP 7.0 and so my hack does not
work anymore.

## Let's use a ~bigger~ cleaner hack

So If I want to continue to use this debug method, I need to put by hand
`declare(ticks=1)` on every PHP files... Boring! I could write a simple tools
that will do that for me but I don't want to modify all my vendors.

So I decided to use PHP Stream Wrapper and Stream Filter. Theses PHP features
are not really well known, but they are very powerful. I encourage you to read
more about it.

This new implementation replaces the default `file` and `phar` stream wrapper
implementation of PHP to be able to automatically add `declare(ticks=1)` on each
PHP file. But this is done only in memory, not physically on the disk.

## Usage


To use it, copy the `HardCoreDebugLogger.php` file somewhere on your disk and
then add the following lines in your code

```php
require '/path/to/HardCoreDebugLogger.php'

HardCoreDebugLogger::register();
```

By default, the traces will be displayed on STDOUT, but you can change it to
save it a file:


```php
require '/path/to/HardCoreDebugLogger.php'

HardCoreDebugLogger::register('/tmp/trace.txt');
```

## Credit

Writing a Stream Wrapper is boring, so I would like to credit [Anthony
Ferrara](https://twitter.com/ircmaxell) for his work on
[php-preprocessor](https://github.com/ircmaxell/php-preprocessor)

# SKV(Simple key-value) storage 
[![Build Status](https://travis-ci.org/drumser/skv.svg?branch=master)](https://travis-ci.org/drumser/skv)
[![codecov](https://codecov.io/gh/drumser/skv/branch/master/graph/badge.svg)](https://codecov.io/gh/drumser/skv)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/drumser/skv/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/drumser/skv/?branch=master)

This is simple implementation of Key-Value database(server and client) using php.

It's 100% covered with PHPUnit and Psalm was able to infer types for 100% of the codebase.

***Created for educational purposes, so do not use it in production***
## Usage
Running server:
```shell script
/usr/bin/php server.php
```

Client example:
```php
<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Amp\ByteStream;
use Amp\Loop;

Loop::run(static function () use ($argv) {
    $stdout = ByteStream\getStdout();

    $uri = 'tcp://127.0.0.1:31337';
    $client = new \Skv\Client\SkvClient(new \Skv\Client\Transport\Tcp\TcpTransport($uri));

    $response = (string)(yield $client->set('hello', 'world'));
    yield $stdout->write($response . PHP_EOL);

    $getResult = yield $client->get('hello');
    yield $stdout->write($getResult . PHP_EOL);
});
```

## TODO
- [x] Base functional Server (Get/Set methods)
- [x] Base functional Client (Get/Set methods)
- [x] Base type support (string,null)
- [x] Psalm
- [x] Tests with phpunit
- [ ] Array type
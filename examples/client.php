<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Amp\ByteStream;
use Amp\Loop;

Loop::run(static function () use ($argv) {
    $stdout = ByteStream\getStdout();

    $uri    = 'tcp://127.0.0.1:31337';
    $client = new \Skv\Client\SkvClient(new \Skv\Client\Transport\Tcp\TcpTransport($uri));

    $response = (string)(yield $client->set('hello', 'world'));
    yield $stdout->write($response . PHP_EOL);

    $getResult = yield $client->get('hello');
    yield $stdout->write($getResult . PHP_EOL);
});
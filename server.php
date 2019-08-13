<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Amp\Loop;
use Amp\Socket\ResourceSocket;
use Amp\Socket\Server;
use function Amp\asyncCoroutine;

Loop::run(static function () {
    $store  = new Skv\Server\Store\Store();
    $stdout = Amp\ByteStream\getStdout();

    $clientHandler = asyncCoroutine(static function (ResourceSocket $socket) use ($store, $stdout) {
        $address = $socket->getRemoteAddress();

        yield $stdout->write("Accepted connection from {$address}." . PHP_EOL);
        $data = yield $socket->read();

        $commandProcessor = new \Skv\Server\Command\CommandProcessor($store);
        $result           = $commandProcessor->process($data);

        $resultData = $result->isSuccessful()
            ? sprintf("SUCCESS\r\n%s", $result->payload)
            : sprintf("ERROR\r\n%s", implode(',', $result->errors));
        yield $socket->end($resultData);
    });

    $server = Server::listen('127.0.0.1:31337');

    echo 'Listening for new connections on ' . $server->getAddress() . ' ...' . PHP_EOL;

    while ($socket = yield $server->accept()) {
        $clientHandler($socket);
    }
});
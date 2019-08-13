<?php
declare(strict_types=1);

namespace Skv\Client;


use Amp\Promise;
use Skv\Client\Transport\TransportInterface;
use Skv\Server\Command\Get;
use Skv\Server\Command\Set;
use Skv\Server\Command\Type\TypeFactory;
use function Amp\call;

class SkvClient implements ClientInterface
{
    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * SrvClient constructor.
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param string $key
     * @psalm-suppress MixedReturnTypeCoercion
     * @return Promise<string>
     */
    public function get(string $key): Promise
    {
        return call(function () use ($key) {
            /** @var string $response */
            $response = yield $this->transport->request(Get::name(), $key);
            [$status, $errorsOrResult] = explode("\r\n", $response);
            if ($status === 'ERROR') {
                throw new \RuntimeException('Errors: ' . $errorsOrResult);
            }
            $rawResult = $errorsOrResult;

            $type = TypeFactory::create($rawResult);
            return $type->unserialize($rawResult);
        });
    }

    /**
     * @param string $key
     * @param mixed $value
     * @psalm-suppress MixedReturnTypeCoercion
     * @return Promise<void>
     */
    public function set(string $key, $value): Promise
    {
        return call(function () use ($key, $value) {
            $type          = TypeFactory::create($value);
            $preparedValue = $type->serialize($value);
            /** @var string $response */
            $response = yield $this->transport->request(Set::name(), "$key,$preparedValue");
            [$status, $errors] = explode("\r\n", $response);
            if ($status === 'ERROR') {
                throw new \RuntimeException('Errors: ' . $errors);
            }
        });
    }
}
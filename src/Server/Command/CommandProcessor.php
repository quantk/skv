<?php
declare(strict_types=1);

namespace Skv\Server\Command;


use Skv\Server\Store\Store;

class CommandProcessor
{
    /**
     * @var Store
     */
    private $store;

    /**
     * CommandProcessor constructor.
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @param string $rawData
     * @return Result
     */
    public function process(string $rawData): Result
    {
        $result = new Result();

        try {
            [$command, $args] = explode(' ', $rawData);
            switch (strtolower($command)) {
                case 'get':
                    $command         = new Get($this->store, $args);
                    $structure       = $command->handle();
                    $result->payload = $structure->evaluate();
                    break;
                case 'set':
                    [$key, $value] = explode(',', $args);
                    $command = new Set($this->store, $key, $value);
                    $command->handle();
                    break;
                default:
                    throw new \RuntimeException('Unknown operation');
            }
        } catch (\Throwable $e) {
            $result->errors[] = $e->getMessage();
        }

        return $result;
    }
}
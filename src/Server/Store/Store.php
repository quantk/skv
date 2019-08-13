<?php
declare(strict_types=1);

namespace Skv\Server\Store;


use Skv\Server\Command\Type\NullType;
use Skv\Server\Command\Type\TypeFactory;

class Store
{
    /**
     * @var array<string, Structure>
     */
    private $store = [];

    /**
     * @param string $key
     * @return Structure
     */
    public function get(string $key): Structure
    {
        return $this->store[$key] ?? new Structure($key, null, new NullType());
    }

    /**
     * @param string $key
     * @param string $data
     */
    public function set(string $key, string $data): void
    {
        $type = TypeFactory::create($data);
        /** @var string $value */
        $value             = substr($data, 1);
        $this->store[$key] = new Structure($key, $value, $type);
    }
}
<?php
declare(strict_types=1);

namespace Skv\Server\Command;


use Skv\Server\Store\Store;

class Set implements SetCommandInterface
{
    /**
     * @var Store
     */
    private $store;
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $value;

    /**
     * Set constructor.
     * @param Store $store
     * @param string $key
     * @param string $value
     */
    public function __construct(
        Store $store,
        string $key,
        string $value
    )
    {
        $this->store = $store;
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public static function name()
    {
        return 'SET';
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->store->set($this->key, $this->value);
    }
}
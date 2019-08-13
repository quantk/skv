<?php
declare(strict_types=1);

namespace Skv\Server\Command;


use Skv\Server\Store\Store;
use Skv\Server\Store\Structure;

class Get implements GetCommandInterface
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
     * Get constructor.
     * @param Store $store
     * @param string $key
     */
    public function __construct(
        Store $store,
        string $key
    )
    {
        $this->store = $store;
        $this->key   = $key;
    }

    /**
     * @return string
     */
    public static function name()
    {
        return 'GET';
    }

    /**
     * @return Structure
     */
    public function handle(): Structure
    {
        return $this->store->get($this->key);
    }
}
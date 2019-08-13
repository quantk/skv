<?php
declare(strict_types=1);

namespace Skv\Server\Store;


use Skv\Server\Command\Type\TypeInterface;

class Structure
{
    /**
     * @var string
     */
    public $key;

    /**
     * @var string|null
     */
    public $value;

    /**
     * @var TypeInterface
     */
    public $type;

    /**
     * Structure constructor.
     * @param string $key
     * @param string|null $value
     * @param TypeInterface $type
     */
    public function __construct(string $key, ?string $value, TypeInterface $type)
    {
        $this->key   = $key;
        $this->value = $value;
        $this->type  = $type;
    }

    /**
     * @return string
     */
    public function evaluate(): string
    {
        return $this->type->serialize($this->value);
    }
}
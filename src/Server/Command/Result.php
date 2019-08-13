<?php
declare(strict_types=1);

namespace Skv\Server\Command;


class Result
{
    /**
     * @var array
     */
    public $errors = [];

    /**
     * @var string|null
     */
    public $payload;

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return count($this->errors) === 0;
    }
}
<?php
declare(strict_types=1);

namespace Skv\Server\Command;


use Skv\Server\Store\Structure;

interface GetCommandInterface
{
    /**
     * @return Structure
     */
    public function handle(): Structure;
}
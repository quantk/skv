<?php
declare(strict_types=1);

namespace Skv\Server\Command;


interface SetCommandInterface
{
    public function handle(): void;
}
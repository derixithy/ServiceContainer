<?php

declare(strict_types=1);

interface ServiceInterface
{
    public function get(string $name): object;

    public function has(string $name): bool;
}

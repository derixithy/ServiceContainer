<?php

declare(strict_types=1);

interface ServiceInterface
{

    /**
     * Creates or returns a service
     * @param  string $name Service name
     * @return object       Service Instance
     * @throws Exception
     */
    public function get(string $name): object;


    /**
     * Returns if service is registered
     * @param  string $name Service name
     * @return bool         Service exists
     */
    public function has(string $name): bool;
}

<?php

declare(strict_types=1);

final class ServiceProvider implements ServiceInterface
{
    private ServiceContainer $services;
    private DefinitionContainer $definitions;

    public function __construct(ServiceContainer $services, DefinitionContainer $definitions)
    {
        $this->services = $services;
        $this->definitions = $definitions;
    }

    public function get(string $name): object
    {
        return $this->services->getService($name);
    }

    public function has(string $name): bool
    {
        return $this->services->hasService($name);
    }

    public function add(string $name, string $class, array $parameters = [])
    {
        $this->definitions->setService($name, $class);

        if (!empty($parameters)) {
            $this->definitions->setParameters($class, $parameters);
        }
        $this->definitions->setParameters($class, $parameters);
    }
}

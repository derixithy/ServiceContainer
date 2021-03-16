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

    /**
     * Creates or returns a service
     * @param  string $name Service name
     * @return object       Service Instance
     * @throws Exception
     */
    public function get(string $name): object
    {
        return $this->services->getService($name);
    }

    /**
     * Returns if service is registered
     * @param  string $name Service name
     * @return bool         Service exists
     */
    public function has(string $name): bool
    {
        return $this->services->hasService($name);
    }

    /**
     * Adds new service to the DefinitionsContainer
     * @param string $name       Service name
     * @param string $class      Service class
     * @param array  $parameters Service parmeters
     */
    public function add(string $name, string $class, array $parameters = []) : void
    {
        $this->definitions->setService($name, $class);

        if (!empty($parameters)) {
            $this->definitions->setParameters($class, $parameters);
        }
        $this->definitions->setParameters($class, $parameters);
    }
}

<?php

class DefinitionContainer
{
    private array $classes = [];
    private array $parameters = [];

    /**
     * sets class for service.
     *
     * @param string $name  Service Name
     * @param string $class Service Service
     */
    public function setService(string $name, string $class): void
    {
        $this->classes[$name] = $class;
    }

    /**
     * Get class for service.
     *
     * @param string $name Service name
     *
     * @return string Service class
     *
     * @throws Exception
     */
    public function getService(string $name): string
    {
        if (!array_key_exists($name, $this->classes)) {
            throw new Exception(sprintf('Service %s not found', $name));
        }

        return $this->classes[$name];
    }

    /**
     * Returns if class is registered for service.
     *
     * @param string $name Service name
     *
     * @return bool Service class registered
     */
    public function hasService(string $name)
    {
        return array_key_exists($name, $this->classes);
    }

    /**
     * Returns if class is registered for service.
     *
     * @param string $name Service name
     *
     * @return bool Service class registered
     */
    public function hasClass(string $name)
    {
        return in_array($name, $this->classes);
    }

    /**
     * Set parameters for service.
     *
     * @param string $name       Service name
     * @param array  $parameters Service parameters
     */
    public function setParameters(string $class, array $parameters): void
    {
        // If it's a service name, get the class
        if ($this->hasService($class)) {
            $class = $this->getService($class);
            echo $class;
        }

        $this->parameters[$class] = $parameters;
    }

    /**
     * Gets parameters for service.
     *
     * @param string $class Class
     *
     * @return array Class parameters
     */
    public function getParameters(string $class): array
    {
        // If it's a service name, get the class
        if ($this->hasService($class)) {
            $class = $this->getService($class);
        }

        if (!array_key_exists($class, $this->parameters)) {
            throw new Exception(sprintf('No parameters found for class %s', $class));
        }

        return $this->parameters[$class];
    }

    /**
     * Returns if service has registered parameters.
     *
     * @param string $class Class
     *
     * @return bool Class has parameters registered
     */
    public function hasParameters(string $class)
    {
        // If it's a service name, get the class
        if ($this->hasService($class)) {
            $class = $this->getService($class);
        }

        return array_key_exists($class, $this->parameters);
    }
}

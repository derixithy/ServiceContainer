<?php

class ServiceContainer
{
    private DefinitionContainer $definitions;
    private array $instances = [];

    /**
     * Constructor.
     *
     * @param ServiceContainer $services Holds service definitions
     */
    public function __construct(DefinitionContainer $definitions)
    {
        $this->definitions = $definitions;
    }

    /**
     * Get instance for registered service.
     *
     * @param string $name Serice name
     *
     * @return object Service instance
     *
     * @throws Exception
     */
    public function getService(string $service): object
    {
        // If it's a service name, get the class for it
        if ($this->definitions->hasService($service)) {
            $service = $this->definitions->getService($service);
        }

        // Create a new instance if necessary
        if (!array_key_exists($service, $this->instances)) {
            $this->instances[$service] = $this->resolveClass($service);
        }

        // Return instance
        return $this->instances[$service];
    }

    /**
     * Resolves given class and returns instance.
     *
     * @param string $class Class te resolve
     *
     * @return object Class instance
     */
    private function resolveClass(string $class): object
    {
        // Create class reflector
        $reflector = new ReflectionClass($class);

        // Stop if class is not instantiable, e.g. abstract class
        if (!$reflector->isInstantiable()) {
            throw new Exception('%s is not instantiable');
        }

        // get constructor
        $constructor = $reflector->getConstructor();

        // create class if no parameters are required
        if (null === $constructor) {
            return new $class();
        }

        // Validate constructor parameters
        $parameters = $constructor->getParameters();
        $dependencies = $this->resolveParameters($class, $parameters);

        // Return new instance
        return $reflector->newInstanceArgs($dependencies);
    }

    public function resolveParameters(string $class, array $parameters)
    {
        if ($this->definitions->hasParameters($class)) {
            return $this->definitions->getParameters($class);
        }

        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if (null === $dependency) { // check for default values
                $dependencies[] = $this->resolveScalarParameter($parameter);
            } else { // get instance for class
                $dependencies[] = $this->resolveClass($dependency->name);
            }
        }

        return $dependencies;
    }

    /**
     * Return default value for parameter.
     *
     * @param ReflectionParameter $parameter Instance parameter
     *
     * @return mixed Parameter default value
     *
     * @throws Exception
     */
    protected function resolveScalarParameter(ReflectionParameter $parameter)
    {
        // If a default value is available return the value
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new InvalidArgumentException('Could not resolve default value');
    }
}

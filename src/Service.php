<?php

final class Service
{
    private static ?ServiceProvider $instance = null;

    /**
     * Redirect calls to ServiceProvider instance
     * @param  string $method     Method name
     * @param  array  $parameters Method parameters
     * @return mixed             ServiceProvider return value
     */
    public static function __callStatic(string $method, array $parameters)
    {
        return call_user_func_array([self::instance(), $method], $parameters);
    }

    /**
     * Holds an instance of ServiceProvider
     * @return ServiceProvider Instance
     */
    public static function instance(): ServiceProvider
    {
        if (null === self::$instance) {
            $definitions = new DefinitionContainer();
            self::$instance = new ServiceProvider(
                new ServiceContainer($definitions),
                $definitions
            );
        }

        return self::$instance;
    }
}

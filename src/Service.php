<?php

final class Service
{
    private static ?ServiceProvider $instance = null;

    public static function __callStatic(string $method, array $parameters)
    {
        return call_user_func_array([self::instance(), $method], $parameters);
    }

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

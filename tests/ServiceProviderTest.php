<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class Service
{
    private string $text;

    public function __construct(string $text = 'Hello World')
    {
        $this->text = $text;
    }

    public function test(): string
    {
        return $this->text;
    }
}

final class ServiceProviderTest extends TestCase
{
    private ServiceContainer $services;
    private ServiceProvider $provider;
    private DefinitionContainer $definitions;

    protected function setUp(): void
    {
        $this->definitions = new DefinitionContainer();
        $this->services = new ServiceContainer(
            $this->definitions
        );
        $this->provider = new ServiceProvider(
            $this->services,
            $this->definitions
        );
    }

    public function testGetSetReturnsTestClass(): void
    {
        $this->provider->add('test', Service::class);

        $test = $this->provider->get('test');

        static::assertInstanceOf(Service::class, $test);
    }

    public function testGetSetWithParametersReturnsTestClass(): void
    {
        $this->provider->add('test', Service::class, ['TestClass']);

        $test = $this->provider->get('test');

        static::assertInstanceOf(Service::class, $test);
        static::assertSame('TestClass', $test->test());

        static::assertSame(['TestClass'], $this->definitions->getParameters(Service::class));
    }
}

<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class Hello
{
    public function test(): string
    {
        return 'Hello World';
    }
}

final class TestParameters
{
    private Hello $test;
    private string $text;

    public function __construct(Hello $test, string $text = 'Hello World')
    {
        $this->text = $text;
        $this->test = $test;
    }

    public function test(): Hello
    {
        return $this->test;
    }

    public function text(): string
    {
        return $this->text;
    }
}

final class ServiceContainerTest extends TestCase
{
    private ServiceContainer $services;
    private DefinitionContainer $provider;

    protected function setUp(): void
    {
        $this->definitions = new DefinitionContainer();
        $this->services = new ServiceContainer(
            $this->definitions
        );
    }

    public function testGetServiceWithoutParameters(): void
    {
        $this->definitions->setService('test', 'Hello');

        $service = $this->services->getService('test');
        static::assertInstanceOf(Hello::class, $service);
    }

    public function testGetServiceWithParametersAndDefaults(): void
    {
        $this->definitions->setService('test', 'TestParameters');

        $service = $this->services->getService('test');
        static::assertInstanceOf(TestParameters::class, $service);

        static::assertInstanceOf(Hello::class, $service->test());
    }

    public function testGetServiceWithParametersAndServiceName(): void
    {
        $this->definitions->setService('test', 'TestParameters');
        $this->definitions->setParameters('test', [new Hello(), 'No Defaults']);

        $service = $this->services->getService('test');
        static::assertInstanceOf(TestParameters::class, $service);

        static::assertSame('No Defaults', $service->text());
    }

    public function testGetServiceWithParametersAndServiceClass(): void
    {
        $this->definitions->setService('test', 'TestParameters');
        $this->definitions->setParameters(Hello::class, [new Hello(), 'No Defaults']);

        $service = $this->services->getService('test');
        static::assertInstanceOf(TestParameters::class, $service);

        static::assertSame('No Defaults', $service->text());
    }
}

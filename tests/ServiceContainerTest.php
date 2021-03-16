<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class Test
{
    public function test(): string
    {
        return 'Hello World';
    }
}

final class TestParameters
{
    private Test $test;
    private string $text;

    public function __construct(Test $test, string $text = 'Hello World')
    {
        $this->text = $text;
        $this->test = $test;
    }

    public function test(): Test
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

    public function setUp(): void
    {
        $this->definitions = new DefinitionContainer();
        $this->services = new ServiceContainer(
            $this->definitions
        );
    }

    public function testGetServiceWithoutParameters(): void
    {
        $this->definitions->setService('test', 'Test');

        $service = $this->services->getService('test');
        $this->assertInstanceOf(Test::class, $service);
    }

    public function testGetServiceWithParametersAndDefaults(): void
    {
        $this->definitions->setService('test', 'TestParameters');

        $service = $this->services->getService('test');
        $this->assertInstanceOf(TestParameters::class, $service);

        $this->assertInstanceOf(Test::class, $service->test());
    }

    public function testGetServiceWithParametersAndServiceName(): void
    {
        $this->definitions->setService('test', 'TestParameters');
        $this->definitions->setParameters('test', [new Test(), 'No Defaults']);

        $service = $this->services->getService('test');
        $this->assertInstanceOf(TestParameters::class, $service);

        $this->assertEquals([new Test(), 'No Defaults'], $this->definitions->getParameters(TestParameters::class));
        $this->assertEquals('No Defaults', $service->text());
    }

    public function testGetServiceWithParametersAndServiceClass(): void
    {
        $this->definitions->setService('test', 'TestParameters');
        $this->definitions->setParameters(Test::class, [new Test(), 'No Defaults']);

        $service = $this->services->getService('test');
        $this->assertInstanceOf(TestParameters::class, $service);

        $this->assertEquals([new Test(), 'No Defaults'], $this->definitions->getParameters(TestParameters::class));
        $this->assertEquals('No Defaults', $service->text());
    }
}

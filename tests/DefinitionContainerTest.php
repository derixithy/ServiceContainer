<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class DefinitionContainerTest extends TestCase
{
    private DefinitionContainer $definitions;

    public function setUp(): void
    {
        $this->definitions = new DefinitionContainer();
    }

    public function testGetServiceThrowsException(): void
    {
        $this->expectException(\Exception::class);

        $this->definitions->getService('test');
    }

    public function testGetServiceAndSetServiceReturnsString(): void
    {
        $this->definitions->setService('test', 'TestClass');

        $class = $this->definitions->getService('test');
        $this->assertEquals('TestClass', $class);
    }

    public function testHasServiceReturnsBoolean(): void
    {
        $this->definitions->setService('test', 'TestClass');

        $hasService = $this->definitions->hasService('test');
        $this->assertEquals(true, $hasService);

        $hasService = $this->definitions->hasService('fail');
        $this->assertEquals(false, $hasService);
    }

    public function testHasClassReturnsBoolean(): void
    {
        $this->definitions->setService('test', 'TestClass');

        $testClass = $this->definitions->hasClass('TestClass');
        $this->assertEquals(true, $testClass);

        $failClass = $this->definitions->hasClass('FailService');
        $this->assertEquals(false, $failClass);
    }

    public function testGetParameterThrowsException(): void
    {
        $this->expectException(\Exception::class);

        $this->definitions->getParameters('test');
    }

    public function testGetParameterAndSetParameterWithServiceNameReturnsString(): void
    {
        $this->definitions->setService('test', 'TestClass');
        $this->definitions->setParameters('test', ['test', 'parameters']);

        $parameters = $this->definitions->getParameters('test');
        $this->assertEquals(['test', 'parameters'], $parameters);
    }

    public function testGetParameterAndSetParameterWithServiceClassReturnsString(): void
    {
        $this->definitions->setService('test', 'TestClass');
        $this->definitions->setParameters('TestClass', ['test', 'parameters']);

        $parameters = $this->definitions->getParameters('TestClass');
        $this->assertEquals(['test', 'parameters'], $parameters);
    }
}

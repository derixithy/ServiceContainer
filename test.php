<?php

require 'src/autoload.php';

final class TestClass
{
    public function test(): string
    {
        return 'Hello World';
    }
}

final class TestParametersClass
{
    private TestClass $test;
    private string $text;

    public function __construct(TestClass $test, string $text = 'Hello World')
    {
        $this->text = $text;
        $this->test = $test;
    }

    public function test(): TestClass
    {
        return $this->test;
    }

    public function text(): string
    {
        return $this->text;
    }
}

Service::add('test', TestClass::class);
Service::add('params', TestParametersClass::class, [new TestClass(), 'Parameters work']);

echo Service::get('test')->test();
echo Service::get('params')->text();

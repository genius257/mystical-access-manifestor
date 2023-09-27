<?php

use Genius257\MysticalAccessManifestor\PasswordGenerator;
use PHPUnit\Framework\TestCase;

class PasswordGeneratorTest extends TestCase
{
    /**
     * @covers \Genius257\MysticalAccessManifestor\PasswordGenerator::__construct
     */
    public function testConstructor()
    {
        $generator = new PasswordGenerator(10);

        $reflectionClass = new ReflectionClass($generator);
        $reflectionProperty = $reflectionClass->getProperty('length');
        $reflectionProperty->setAccessible(true);

        $this->assertEquals(10, $reflectionProperty->getValue($generator));
    }

    /**
     * @covers \Genius257\MysticalAccessManifestor\PasswordGenerator::generate
     */
    public function testGenerate()
    {
        $generator = new PasswordGenerator(10);

        $actual = $generator->generate();

        $this->assertEquals(10, strlen($actual));
    }
}

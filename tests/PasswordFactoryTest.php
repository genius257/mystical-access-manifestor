<?php

use Genius257\MysticalAccessManifestor\Decorators\LowerCase;
use Genius257\MysticalAccessManifestor\Decorators\Number;
use Genius257\MysticalAccessManifestor\Decorators\Symbol;
use Genius257\MysticalAccessManifestor\Decorators\UpperCase;
use Genius257\MysticalAccessManifestor\PasswordDecorator;
use Genius257\MysticalAccessManifestor\PasswordFactory;
use Genius257\MysticalAccessManifestor\PasswordGenerator;
use PHPUnit\Framework\TestCase;

class PasswordFactoryTest extends TestCase
{
    /**
     * @covers \Genius257\MysticalAccessManifestor\PasswordFactory::__construct
     */
    public function testConstructor()
    {
        $factory = new PasswordFactory(10);

        $reflectionClass = new ReflectionClass($factory);
        $reflectionProperty = $reflectionClass->getProperty('generator');
        $reflectionProperty->setAccessible(true);
        $expected = $reflectionProperty->getValue($factory);

        $this->assertInstanceOf(PasswordGenerator::class, $expected);
    }

    /**
     * @covers \Genius257\MysticalAccessManifestor\PasswordFactory::withLowercase
     */
    public function testWithLowercase()
    {
        $factory = new PasswordFactory(10);

        $this->assertNotInstanceOf(LowerCase::class, $factory->build());

        $factory->withLowercase(10);

        $this->assertInstanceOf(LowerCase::class, $factory->build());
    }

    /**
     * @covers \Genius257\MysticalAccessManifestor\PasswordFactory::withNumbers
     */
    public function testWithNumbers()
    {
        $factory = new PasswordFactory(10);

        $this->assertNotInstanceOf(Number::class, $factory->build());

        $factory->withNumbers(10);

        $this->assertInstanceOf(Number::class, $factory->build());
    }

    /**
     * @covers \Genius257\MysticalAccessManifestor\PasswordFactory::withSymbols
     */
    public function testWithSymbols()
    {
        $factory = new PasswordFactory(10);

        $this->assertNotInstanceOf(Symbol::class, $factory->build());

        $factory->withSymbols(10);

        $this->assertInstanceOf(Symbol::class, $factory->build());
    }

    /**
     * @covers \Genius257\MysticalAccessManifestor\PasswordFactory::withUppercase
     */
    public function testWithUppercase()
    {
        $factory = new PasswordFactory(10);

        $this->assertNotInstanceOf(UpperCase::class, $factory->build());

        $factory->withUppercase(10);

        $this->assertInstanceOf(UpperCase::class, $factory->build());
    }

    /**
     * @covers \Genius257\MysticalAccessManifestor\PasswordFactory::build
     */
    public function testBuild()
    {
        $factory = new PasswordFactory(10);

        $reflectionClass = new ReflectionClass($factory);
        $reflectionProperty = $reflectionClass->getProperty('generator');
        $reflectionProperty->setAccessible(true);
        $expected = $reflectionProperty->getValue($factory);

        $this->assertEquals($expected, $factory->build());
    }

    /**
     * @coversNothing
     */
    public function testBuildWithMultipleDecorators()
    {
        $factory = new PasswordFactory(10);

        /** The initial decorator from the factory */
        $baseDecorator = $factory->build();

        $factory->withNumbers(4);
        $factory->withLowercase(6);
        $factory->withSymbols(2);
        $finalDecorator = $factory->build();

        $extractParentGenerator = function (PasswordDecorator $factory) {
            $reflectionClass = new ReflectionClass($factory);
            $reflectionProperty = $reflectionClass->getProperty('generator');
            $reflectionProperty->setAccessible(true);
            return $reflectionProperty->getValue($factory);
        };

        $decorator = $finalDecorator;
        $this->assertInstanceOf(Symbol::class, $decorator);

        $decorator = $extractParentGenerator($decorator);
        $this->assertInstanceOf(LowerCase::class, $decorator);

        $decorator = $extractParentGenerator($decorator);
        $this->assertInstanceOf(Number::class, $decorator);

        $decorator = $extractParentGenerator($decorator);
        $this->assertInstanceOf(get_class($baseDecorator), $decorator);
    }
}

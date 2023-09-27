<?php

use Genius257\MysticalAccessManifestor\PasswordDecorator;
use Genius257\MysticalAccessManifestor\PasswordGenerator;
use PHPUnit\Framework\TestCase;

class PasswordDecoratorTest extends TestCase
{
    public function makeInstance(...$args)
    {
        return new class (...$args) extends PasswordDecorator
        {
            protected string $chars = 'abc';
        };
    }

    /**
     * @covers Genius257\MysticalAccessManifestor\PasswordDecorator::__construct
     */
    public function testConstructor()
    {
        $instance = $this->makeInstance(new PasswordGenerator(10), 10);

        // This test only checks that the constructor works, not that it does anything.
        $this->assertEquals(1, 1);
    }

    /**
     * @covers Genius257\MysticalAccessManifestor\PasswordDecorator::generate
     */
    public function testGenerate()
    {
        $instance = $this->makeInstance(new PasswordGenerator(3), 3);
        $generated = $instance->generate();
        $actual = str_split($generated);
        sort($actual);
        $actual = implode($actual);

        $this->assertEquals('abc', $actual);
    }

    /**
     * If the length of the generated password is greater than the length of the characters,
     * then the generated password should be the characters repeated.
     *
     * @covers Genius257\MysticalAccessManifestor\PasswordDecorator::generate
     */
    public function testGenerateWithLengthOverflow()
    {
        $instance = $this->makeInstance(new PasswordGenerator(10), 10);
        $generated = $instance->generate();

        $this->assertMatchesRegularExpression('/^[abc]{10}$/', $generated);
    }

    /**
     * If a decorator recives a string with no available placeholders, then the generated password not be altered.
     *
     * @covers Genius257\MysticalAccessManifestor\PasswordDecorator::generate
     */
    public function testGenerateWithNoAvailablePlaceholders()
    {
        $precedingDecorator = new class (new PasswordGenerator(10), 10) extends PasswordDecorator {
            protected string $chars = 'xyz';

            public function generate(): string
            {
                return 'xyzxyzxyzx';
            }
        };

        $instance = $this->makeInstance($precedingDecorator, 10);

        $actual = $instance->generate();

        $this->assertDoesNotMatchRegularExpression('/[abc]/', $actual);

        $this->assertMatchesRegularExpression('/^[xyz]{10}$/', $actual);
    }
}

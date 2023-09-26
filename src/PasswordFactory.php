<?php

namespace Genius257\MysticalAccessManifestor;

use Genius257\MysticalAccessManifestor\Decorators\LowerCase;
use Genius257\MysticalAccessManifestor\Decorators\Number;
use Genius257\MysticalAccessManifestor\Decorators\UpperCase;
use Genius257\MysticalAccessManifestor\Decorators\Symbol;

class PasswordFactory
{
    protected $generator;

    public function __construct(int $length)
    {
        $this->generator = new PasswordGenerator($length);
    }

    public function withLowercase(int $length): self
    {
        $this->generator = new LowerCase($this->generator, $length);

        return $this;
    }

    public function withUppercase(int $length): self
    {
        $this->generator = new UpperCase($this->generator, $length);

        return $this;
    }

    public function withNumbers(int $length): self
    {
        $this->generator = new Number($this->generator, $length);

        return $this;
    }

    public function withSymbols(int $length): self
    {
        $this->generator = new Symbol($this->generator, $length);

        return $this;
    }

    public function build(): Generator
    {
        return $this->generator;
    }
}

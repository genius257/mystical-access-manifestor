<?php

namespace Genius257\MysticalAccessManifestor;

class PasswordGenerator implements Generator
{
    public function __construct(protected int $length)
    {
    }

    public function generate(): string
    {
        return str_pad('', $this->length, "\0");
    }
}

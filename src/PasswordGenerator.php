<?php

namespace Genius257\MysticalAccessManifestor;

class PasswordGenerator implements Generator
{
    public function __construct(protected int $length)
    {
    }

    public function generate(): string
    {
        return str_repeat("\0", $this->length);
    }
}

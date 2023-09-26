<?php

namespace Genius257\MysticalAccessManifestor\Decorators;

use Genius257\MysticalAccessManifestor\PasswordDecorator;

class Number extends PasswordDecorator
{
    protected string $chars = '0123456789';
}

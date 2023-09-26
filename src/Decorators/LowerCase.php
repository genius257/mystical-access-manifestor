<?php

namespace Genius257\MysticalAccessManifestor\Decorators;

use Genius257\MysticalAccessManifestor\PasswordDecorator;

class LowerCase extends PasswordDecorator
{
    protected string $chars = 'abcdefghijklmnopqrstuvwxyz';
}

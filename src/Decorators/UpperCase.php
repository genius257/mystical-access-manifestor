<?php

namespace Genius257\MysticalAccessManifestor\Decorators;

use Genius257\MysticalAccessManifestor\PasswordDecorator;

class UpperCase extends PasswordDecorator
{
    protected string $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
}

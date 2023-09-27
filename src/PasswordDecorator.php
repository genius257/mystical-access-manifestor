<?php

namespace Genius257\MysticalAccessManifestor;

abstract class PasswordDecorator implements Generator
{
    protected string $chars;

    public function __construct(protected Generator $generator, protected int $length)
    {
    }

    public function generate(): string
    {
        $generated = $this->generator->generate();

        // Find all occurences of the placeholder char
        preg_match_all('/\0/', $generated, $matches, PREG_OFFSET_CAPTURE);
        
        // If no placeholder is found, just return the previous generated password
        if (empty($matches[0])) {
            return $generated;
        }

        /**
         * Random position(s) from the available placeholders
         */
        $targets = array_rand($matches[0], $this->length);
        $chars = str_shuffle($this->chars);
        foreach ($targets as $index => $target) {
            $generated[$matches[0][$target][1]] = $chars[$index];
        }

        return $generated;
    }
}

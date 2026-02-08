<?php

declare(strict_types=1);

namespace Vewe\ClassVariance\Parsers;

use Vewe\ClassVariance\Collections\StringCollection;

final readonly class ClassNamesParser
{
    private function __construct(
        private StringCollection $items = new StringCollection(),
        private string $slot = '',
    ) {}

    /**
     * @param array<array-key, array<array-key, string>|string>|string $classNames
     * @param string $slot
     */
    public static function of(string|array $classNames, string $slot = ''): self
    {
        $items = [];

        if (is_array($classNames)) {
            // Extract the matching slot when present
            if ($slot !== '') {
                $extracted = $classNames[$slot] ?? [];
                // Handle case where slot value is a string
                if (is_string($extracted)) {
                    $items = explode(' ', $extracted);
                } else {
                    $items = $extracted;
                }
            } else {
                $items = $classNames;
            }
        }

        if (is_string($classNames)) {
            $items = explode(' ', $classNames);
        }

        /** @var array<array-key, string> $items */
        return new self(new StringCollection($items));
    }

    public static function empty(): self
    {
        return new self();
    }

    public function concat(ClassNamesParser $classNames): self
    {
        return new self(
            $this->items->concat($classNames->items),
        );
    }

    public function toString(): string
    {
        return $this->items
            ->unique()
            ->filter(fn (string $value) => trim($value) !== '')
            ->implode(' ');
    }
}

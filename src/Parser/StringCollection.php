<?php

declare(strict_types=1);

namespace Vewe\Mcva\Parser;

final readonly class StringCollection
{
    /**
     * @param array<array-key, string> $items
     */
    public function __construct(
        private array $items = [],
    ) {}

    public function implode(string $separator): string
    {
        return implode($separator, $this->items);
    }

    /**
     * @param (callable(array-key): bool)|(callable(string): bool)|(callable(string, array-key): bool)|null $callback
     */
    public function filter(?callable $callback = null): self
    {
        return new self(array_filter($this->items, $callback));
    }

    public function unique(): self
    {
        return new self(array_unique($this->items));
    }

    public function concat(StringCollection $collection): self
    {
        return new self([
            ...$this->items,
            ...$collection->items,
        ]);
    }
}

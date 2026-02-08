<?php

declare(strict_types=1);

namespace Vewe\ClassVariance\Processors;

use Vewe\ClassVariance\Parsers\ClassNamesParser;

final readonly class VariantsProcessor
{
    /**
     * @param array<array-key, array<array-key, string|array<array-key, string>|array<array-key, string|array<array-key, string>>>> $processorCollection
     */
    private function __construct(
        private array $processorCollection,
    ) {}

    /**
     * @param array<array-key, array<array-key, string|array<array-key, string>|array<array-key, string|array<array-key, string>>>> $processorCollection
     */
    public static function of(array $processorCollection): self
    {
        return new self($processorCollection);
    }

    /**
     * @param array<array-key, string> $props
     */
    public function resolve(array $props, string $slot = ''): ClassNamesParser
    {
        $classNames = ClassNamesParser::empty();
        foreach ($props as $key => $value) {
            $classNames = $classNames->concat(ClassNamesParser::of($this->processorCollection[$key][$value] ?? '', $slot));
        }

        return $classNames;
    }
}

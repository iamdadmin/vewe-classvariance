<?php

declare(strict_types=1);

namespace Vewe\ClassVariance\Processors;

use Vewe\ClassVariance\Parsers\ClassNamesParser;

final readonly class CompoundVariantsProcessor
{
    /**
     * @param array<array-key, array<array-key, string|array<array-key, string>>> $processorCollection
     */
    private function __construct(
        private array $processorCollection,
    ) {}

    /**
     * @param array<array-key, array<array-key, string|array<array-key, string>>> $processorCollection
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
        foreach ($this->processorCollection as $compoundVariant) {
            if (! $this->matches($props, $compoundVariant)) {
                continue;
            }

            $classNames = $classNames->concat(ClassNamesParser::of(
                $compoundVariant['class'] ?? $compoundVariant['className'] ?? '',
                $slot,
            ));
        }

        return $classNames;
    }

    /**
     * @param array<array-key, string> $props
     * @param array<array-key, string|array<array-key, string>> $compoundVariant
     * @return bool
     */
    private function matches(array $props, array $compoundVariant): bool
    {
        foreach ($compoundVariant as $key => $value) {
            if ($key === 'class' || $key === 'className') {
                continue;
            } elseif ($props[$key] !== $value) {
                return false;
            }
        }

        return true;
    }
}

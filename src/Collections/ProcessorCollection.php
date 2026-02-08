<?php

declare(strict_types=1);

namespace Vewe\ClassVariance\Collections;

use Vewe\ClassVariance\Processors\CompoundVariantsProcessor;
use Vewe\ClassVariance\Processors\DefaultVariantsProcessor;
use Vewe\ClassVariance\Processors\VariantsProcessor;

final readonly class ProcessorCollection
{
    public function __construct(
        public VariantsProcessor $variants,
        public CompoundVariantsProcessor $compoundVariants,
        public DefaultVariantsProcessor $defaultVariants,
    ) {}

    /**
     * @param array{
     *     variants?: array<array-key, array<array-key, string|array<array-key, string>|array<array-key, string|array<array-key, string>>>>,
     *     compoundVariants?: array<array-key, array<array-key, string|array<array-key, string>>>,
     *     defaultVariants?: array<array-key, string>
     * } $processorCollection
     */
    public static function of(array $processorCollection): self
    {
        return new self(
            VariantsProcessor::of($processorCollection['variants'] ?? []),
            CompoundVariantsProcessor::of($processorCollection['compoundVariants'] ?? []),
            DefaultVariantsProcessor::of($processorCollection['defaultVariants'] ?? []),
        );
    }
}

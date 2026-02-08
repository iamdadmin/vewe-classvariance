<?php

declare(strict_types=1);

namespace Vewe\ClassVariance;

use Vewe\ClassVariance\Collections\ProcessorCollection;
use Vewe\ClassVariance\Parsers\ClassNamesParser;

final readonly class Cv
{
    public function __construct(
        public ClassNamesParser $base,
        public ProcessorCollection $processorCollection,
        public string $slot = '',
    ) {}

    /**
     * @param string|array<array-key, string|array<array-key, string>> $base
     * @param array{
     *     variants?: array<array-key, array<array-key, string|array<array-key, string>|array<array-key, string|array<array-key, string>>>>,
     *     compoundVariants?: array<array-key, array<array-key, string|array<array-key, string>>>,
     *     defaultVariants?: array<array-key, string>
     * } $processorCollection
     * @param string $slot
     */
    public static function new(string|array $base, array $processorCollection, string $slot = ''): self
    {
        // Auto-detect slot if base is an associative array with a single key
        if ($slot === '' && is_array($base) && count($base) === 1 && ! isset($base[0])) {
            $slot = array_key_first($base);
        }

        // If base has multiple slots but no slot specified, default to 'base' with warning
        if ($slot === '' && is_array($base) && count($base) > 1 && ! isset($base[0])) {
            trigger_error(
                'Multiple slots detected in base array but no $slot parameter provided. Defaulting to "base" slot. '
                . 'Please specify a slot explicitly or use single-slot structure.',
                E_USER_WARNING,
            );
            $slot = 'base';
        }

        /** @var string $slot */
        return new self(
            ClassNamesParser::of($base, $slot),
            ProcessorCollection::of($processorCollection),
            $slot,
        );
    }

    /**
     * @param array<array-key, string> $props
     */
    public function __invoke(array $props = []): string
    {
        $props = $this->processorCollection->defaultVariants->merge($props);
        $slot = $this->slot ?? '';

        $additionalClassNames = ClassNamesParser::of($props['class'] ?? $props['className'] ?? '', $slot);

        // Base is an instance of ClassNames at this point
        return $this->base
            ->concat($this->processorCollection->variants->resolve($props, $slot))
            ->concat($this->processorCollection->compoundVariants->resolve($props, $slot))
            ->concat($additionalClassNames)
            ->toString();
    }
}

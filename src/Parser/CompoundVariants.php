<?php

declare(strict_types=1);

namespace Vewe\Mcva\Parser;

final readonly class CompoundVariants
{
    /**
     * @param array<array-key, array<array-key, string|array<array-key, string>>> $config
     */
    private function __construct(
        private array $config,
    ) {}

    /**
     * @param array<array-key, array<array-key, string|array<array-key, string>>> $config
     */
    public static function of(array $config): self
    {
        return new self($config);
    }

    /**
     * @param array<array-key, string> $props
     */
    public function resolve(array $props, string $slot = ''): ClassNames
    {
        $classNames = ClassNames::empty();
        foreach ($this->config as $compoundVariant) {
            if (! $this->matches($props, $compoundVariant)) {
                continue;
            }

            $classNames = $classNames->concat(ClassNames::of(
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

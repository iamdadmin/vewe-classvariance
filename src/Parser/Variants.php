<?php

declare(strict_types=1);

namespace Vewe\Mcva\Parser;

final readonly class Variants
{
    /**
     * @param array<array-key, array<array-key, string|array<array-key, string>|array<array-key, string|array<array-key, string>>>> $config
     */
    private function __construct(
        private array $config,
    ) {}

    /**
     * @param array<array-key, array<array-key, string|array<array-key, string>|array<array-key, string|array<array-key, string>>>> $config
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
        foreach ($props as $key => $value) {
            $classNames = $classNames->concat(ClassNames::of($this->config[$key][$value] ?? '', $slot));
        }

        return $classNames;
    }
}

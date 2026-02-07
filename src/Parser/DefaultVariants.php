<?php

declare(strict_types=1);

namespace Vewe\Mcva\Parser;

final readonly class DefaultVariants
{
    /**
     * @param array<array-key, string> $config
     */
    private function __construct(
        private array $config,
    ) {}

    /**
     * @param array<array-key, string> $config
     */
    public static function of(array $config): self
    {
        return new self($config);
    }

    /**
     * @param array<array-key, string> $props
     * @return array<array-key, string>
     */
    public function merge(array $props): array
    {
        foreach ($this->config as $key => $value) {
            $props[$key] ??= $value;
        }

        return $props;
    }
}

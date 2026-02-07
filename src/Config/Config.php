<?php

declare(strict_types=1);

namespace Vewe\Mcva\Config;

use Vewe\Mcva\Parser\CompoundVariants;
use Vewe\Mcva\Parser\DefaultVariants;
use Vewe\Mcva\Parser\Variants;

final readonly class Config
{
    public function __construct(
        public Variants $variants,
        public CompoundVariants $compoundVariants,
        public DefaultVariants $defaultVariants,
    ) {}

    /**
     * @param array{
     *     variants?: array<array-key, array<array-key, string|array<array-key, string>|array<array-key, string|array<array-key, string>>>>,
     *     compoundVariants?: array<array-key, array<array-key, string|array<array-key, string>>>,
     *     defaultVariants?: array<array-key, string>
     * } $config
     */
    public static function of(array $config): self
    {
        return new self(
            Variants::of($config['variants'] ?? []),
            CompoundVariants::of($config['compoundVariants'] ?? []),
            DefaultVariants::of($config['defaultVariants'] ?? []),
        );
    }
}

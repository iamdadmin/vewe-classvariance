# Vewe ClassVariance

## About

Aiming to be an all-PHP combined implementation of Class Variance Authority, twMerge, and Tailwind-Variants.

Supporting the current version of PHP, less one, as a minimum requirement, to keep the package freshly maintained and utilising the latest features of PHP.

## Version Strategy

Based on semantic versioning, with the following constraints

1.x.x releases support PHP8.4, PHP8.5
2.x.x releases support PHP8.5, PHP8.6
3.x.x releases support PHP8.6, PHP-Next (tbc)

Major point releases may introduce breaking changes, which will be in the release notes.

Minor point releases should be non-breaking changes and fixes.

## Installation

You can install the package via composer:

```bash
composer require feature-ninja/cva
```

## Usage

```php
use FeatureNinja\Cva\ClassVarianceAuthority;

$button = ClassVarianceAuthority::new(
    ['font-semibold', 'border', 'rounded'],
    [
        'variants' => [
            'intent' => [
                'primary' => ['bg-blue-500', 'text-white', 'border-transparent', 'hover:bg-blue-600'],
                'secondary' => 'bg-white text-gray-800 border-gray-400 hover:bg-gray-100',
            ],
            'size' => [
                'small' => ['text-sm', 'py-1', 'px-2'],
                'medium' => 'text-base py-2 px-4',
            ],
        ],
        'compoundVariants' => [
            [
                'intent' => 'primary',
                'size' => 'medium',
                'class' => 'uppercase',
            ],
        ],
        'defaultVariants' => [
            'intent' => 'primary',
            'size' => 'medium',
        ],
    ],
);

# Or by using the cva helper function

$button = fn\cva(
    ['font-semibold', 'border', 'rounded'],
    [
        'variants' => [
            'intent' => [
                'primary' => ['bg-blue-500', 'text-white', 'border-transparent', 'hover:bg-blue-600'],
                'secondary' => 'bg-white text-gray-800 border-gray-400 hover:bg-gray-100',
            ],
            'size' => [
                'small' => ['text-sm', 'py-1', 'px-2'],
                'medium' => 'text-base py-2 px-4',
            ],
        ],
        'compoundVariants' => [
            [
                'intent' => 'primary',
                'size' => 'medium',
                'class' => 'uppercase',
            ],
        ],
        'defaultVariants' => [
            'intent' => 'primary',
            'size' => 'medium',
        ],
    ],
);
```

```html
<button class="<?= $button(); ?>">Submit</button>

<button class="<?= $button(['intent' => 'secondary', 'size' => 'small']); ?>">Submit</button>
```

## Testing

```bash
composer test
```

## Acknowledgements

Thank you to the following, without whom this package would not exist.

- [CVA](https://github.com/feature-ninja/cva) by [Roj Vroemen](https://github.com/rojtjo) and contributors
- [Class Variance Authority](https://github.com/joe-bell/cva) by [Joe Bell](https://github.com/joe-bell)
- [Tailwind-Variants](https://github.com/heroui-inc/tailwind-variants) by [Junior Garcia @jrgarciadev](https://github.com/jrgaciadev), [Tianen Pang @tianenpang](https://github.com/tianenpang) and contributors
- [Tailwind-merge](https://github.com/tales-from-a-dev/tailwind-merge-php) by [Romain Monteil](https://github.com/ker0x) which is based on [Tailwind-merge-php](https://github.com/gehrisandro/tailwind-merge-php) by [Sandro Gehri](https://github.com/gehrisandro) and contributors

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
# uwuify-php
Uwuify any sentence or word with various options.

<div id="badges">
    <img src="https://img.shields.io/packagist/v/nemo9l/uwuify?color=F85E83&label=uwuify&logo=php&style=flat-square" alt="PHP version >= 8.0" />
    <img src="https://img.shields.io/packagist/l/nemo9l/uwuify?color=F85E83&logo=mit&style=flat-square" alt="License MIT" />
    <img src="https://img.shields.io/packagist/dm/nemo9l/uwuify?color=F85E83&logo=mit&style=flat-square" alt="Download counts, Sorry for screen reader." />
</div>

## Installation
```bash
composer require nemo9l/uwuify
composer install
```

## Usage

### Basic usage

```php
$uwuifier = new Nemo9l\Uwuify\Uwuify();
$result = $uwuifier->uwuify('Uwuify any sentence or word with various options.');
```

### Advanced usage

```php
// (float $regexModifier = null, float $exclamationModifier = null, array $spaceModifier = [])
$uwuifier = new Nemo9l\Uwuify\Uwuify(0.75, 0.75, [ 'faces' => 0.025, 'actions' => 0.025, 'stutter' => 0.05 ]);
$result = $uwuifier->uwuify('Uwuify any sentence or word with various options.');
```

#### $regexModifier
`$regexModifier` property affects what percentage of regex(defined at `static $_regexMaps`) replacements will be applied to the sentence.  
Default value is `1.0` which means 100% of regex replacements will be applied.

#### $exclamationModifier
`$exclamationModifier` property affects what percentage of exclamation marks(defined at `static $_exclamations`) will be replaced.

#### $spaceModifier
`$spaceModifier` property affects what percentage of spaces will be replaced with various options.
It can be an array with following keys:
- `faces` - affects what percentage of spaces will be replaced with faces(defined at `static $_faces`).
- `actions` - affects what percentage of spaces will be replaced with actions(defined at `static $_actions`).
- `stutter` - affects what percentage of spaces will have some appends to make it stutter.

### License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
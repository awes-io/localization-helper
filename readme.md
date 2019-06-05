# LocalizationHelper

[![Coverage report](https://repo.pkgkit.com/4GBWO/awes-io/localization-helper/badges/master/coverage.svg)](https://www.awes.io/)
[![Build status](https://repo.pkgkit.com/4GBWO/awes-io/localization-helper/badges/master/build.svg)](https://www.awes.io/)
[![Composer Ready](https://www.pkgkit.com/4GBWO/awes-io/localization-helper/status.svg)](https://www.awes.io/)
[![Downloads](https://www.pkgkit.com/4GBWO/awes-io/localization-helper/downloads.svg)](https://www.awes.io/)
[![Last version](https://www.pkgkit.com/4GBWO/awes-io/localization-helper/version.svg)](https://www.awes.io/)

Package for convenient work with Laravel's localization features and fast language files generation. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require awes-io/localization-helper
```

In Laravel 5.5+, service provider and facade will be automatically registered. For older versions, follow the steps below:

Register service provider in `config/app.php`:

```php
'providers' => [
// [...]
        AwesIO\LocalizationHelper\LocalizationHelperServiceProvider::class,
],
```

You may also register `LaravelLocalization` facade:

```php
'aliases' => [
// [...]
        'LocalizationHelper' => AwesIO\LocalizationHelper\Facades\LocalizationHelper::class,
],
```

## Config

### Config Files

In order to edit default configuration you may execute:

```
php artisan vendor:publish --provider="AwesIO\LocalizationHelper\LocalizationHelperServiceProvider"
```

After that, `config/localizationhelper.php` will be created.

## Usage

Package registers global helper function `_p($file_key, $default, $placeholders)`:

```php
_p('auth.login', 'Login'); // "Login"
```

It will create new localization file `auth.php` (if it doesn't exist) and write second parameter as language string under `login` key:

```php
return [
    "login" => "Login"
];
```

On second call with same file/key `_p('auth.login')`, localization string will be returned, file will remain untouched.

Placeholders are also supported:

```php
_p(
    'mail.invitation', 
    'You’re invited to join :company company workspace', 
    ['company' => 'Awesio']
);
```

If key is returned, it means that string already exists in localization file and you are trying to add new one using its value as an array.

```php
// in localization file.php
return [
    "test" => "Test string"
];

_p('file.test.new', 'Test string'); // will return "file.test.new"

_p('file.test_2.new', 'Test string'); // will return "Test string"

// and modify localization file:
return [
    "test" => "Test string",
    "test_2" => [
        "new" => "Test string"
    ]
];
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email info@awescrm.de instead of using the issue tracker.

## Credits

- [Galymzhan Begimov](https://github.com/begimov)
- [All Contributors](contributing.md)

## License

[MIT](http://opensource.org/licenses/MIT)

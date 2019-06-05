# LocalizationHelper

[![Coverage report](https://repo.pkgkit.com/4GBWO/awes-io/localization-helper/badges/master/coverage.svg)](https://www.awes.io/)
[![Build status](https://repo.pkgkit.com/4GBWO/awes-io/localization-helper/badges/master/build.svg)](https://www.awes.io/)
[![Composer Ready](https://www.pkgkit.com/4GBWO/awes-io/auth/status.svg)](https://www.awes.io/)
[![Downloads](https://www.pkgkit.com/4GBWO/awes-io/auth/downloads.svg)](https://www.awes.io/)
[![Last version](https://www.pkgkit.com/4GBWO/awes-io/auth/version.svg)](https://www.awes.io/)

Package for convenient work with Laravel's localization features. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require awes-io/localization-helper
```

In Laravel 5.5, the service provider and facade will automatically get registered. For older versions of the framework, follow the steps below:

Register the service provider in config/app.php
```php
'providers' => [
// [...]
        AwesIO\LocalizationHelper\LocalizationHelperServiceProvider::class,
],
```

You may also register the LaravelLocalization facade:

```php
'aliases' => [
// [...]
        'LocalizationHelper' => AwesIO\LocalizationHelper\Facades\LocalizationHelper::class,
],
```

## Config

### Config Files

In order to edit the default configuration for this package you may execute:

```
php artisan vendor:publish --provider="AwesIO\LocalizationHelper\LocalizationHelperServiceProvider"
```

After that, `config/localizationhelper.php` will be created.

## Usage

Package registers global helper function:

```php
_p('auth.login', 'Login');
```

Placeholders support:

```php
_p(
    'mail.invitation', 
    'You’re invited to join :company company workspace', 
    ['company' => $this->data['company']]
);
```

If key is returned, it means that string already exists and you trying to add new one using it as array.

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

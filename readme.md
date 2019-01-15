# LocalizationHelper

[![Coverage report](http://gitlab.awescode.com/awes-io/localization-helper/badges/master/coverage.svg)](https://www.awes.io/)
[![Build status](http://gitlab.awescode.com/awes-io/localization-helper/badges/master/build.svg)](https://www.awes.io/)
[![Composer Ready](https://www.awc.wtf/awes-io/localization-helper/status.svg)](https://www.awes.io/)
[![Downloads](https://www.awc.wtf/awes-io/localization-helper/downloads.svg)](https://www.awes.io/)
[![Last version](https://www.awc.wtf/awes-io/localization-helper/version.svg)](https://www.awes.io/)

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require AwesIO/localizationhelper
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

- [AwesCRM][link-author]
- [All Contributors][link-contributors]

## License

GNU General Public License v3.0. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/AwesIO/localizationhelper.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/AwesIO/localizationhelper.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/AwesIO/localizationhelper/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/AwesIO/localizationhelper
[link-downloads]: https://packagist.org/packages/AwesIO/localizationhelper
[link-travis]: https://travis-ci.org/AwesIO/localizationhelper
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/AwesIO
[link-contributors]: ../../contributors]

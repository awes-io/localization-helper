# Localization Helper

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

## Testing

``` bash
$ composer test
```

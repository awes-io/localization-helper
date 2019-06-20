# Localization Helper

Package for convenient work with Laravel's localization features and fast language files generation.

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

It will create new localization file `auth.php` (if it doesn't exist) for fallback locale and write second parameter as language string under `login` key:

```php
return [
    "login" => "Login"
];
```

Array can be used as default value:

```php
_p('auth.login', ['en' => 'Login', 'fr' => 'Connexion']);
```

It will create files `auth.php` for every locale from array keys and write array value as language string.

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

## Testing

``` bash
$ composer test
```

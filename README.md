Laravel Mapbox
==============

[![Build status](https://img.shields.io/travis/com/bakerkretzmar/laravel-mapbox.svg?style=flat)](https://travis-ci.org/bakerkretzmar/laravel-mapbox)
[![StyleCI](https://github.styleci.io/repos/192925375/shield?branch=master&style=flat)](https://github.styleci.io/repos/192925375)
[![Latest stable version](https://img.shields.io/packagist/v/bakerkretzmar/laravel-mapbox.svg?style=flat)](https://packagist.org/packages/bakerkretzmar/laravel-mapbox)
[![Total downloads](https://img.shields.io/packagist/dt/bakerkretzmar/laravel-mapbox.svg?style=flat)](https://packagist.org/packages/bakerkretzmar/laravel-mapbox)
[![MIT license](https://img.shields.io/packagist/l/bakerkretzmar/laravel-mapbox.svg?style=flat)](https://github.com/bakerkretzmar/laravel-mapbox/blob/master/LICENSE)

A lightweight wrapper to make working with [Mapbox](https://docs.mapbox.com/api/maps) Maps service APIs in [Laravel](https://laravel.com) apps a breeze. Based on Matt Fox’s [`mapbox-api-laravel`](https://github.com/BlueVertex/mapbox-api-laravel).

This package supports managing the following services via the Mapbox API:

[Datasets](#datasets) • [Features](#features) • [Tilesets](#tilesets) • [Uploads](#uploads)

Installation
------------

```bash
composer require bakerkretzmar/laravel-mapbox
```

Configuration
-------------

Add the following to your `.env` file:

```bash
MAPBOX_USERNAME={your Mapbox username}
MAPBOX_TOKEN={your Mapbox access token}
```

Optionally, you can publish the package’s config file:

```bash
php artisan vendor:publish --provider="bakerkretzmar\LaravelMapbox\LaravelMapboxServiceProvider"
```

Usage
-----

### Datasets

[Mapbox documentation.](https://docs.mapbox.com/api/maps/#datasets)

**List Datasets:**

```php
$datasets = Mapbox::datasets()->list();
```

**Retrieve a Dataset:**

```php
$dataset = Mapbox::datasets($dataset_id)->get();
```

**Create a Dataset:**

```php
$dataset = Mapbox::datasets()->create();
// or
$dataset = Mapbox::datasets()->create([
    'name' => 'My Dataset',
    'description' => 'A new Mapbox Dataset',
]);
```

**Update a Dataset:**

```php
$dataset = Mapbox::datasets($dataset_id)->update([
    'name' => 'My Updated Dataset',
    'description' => 'An updated Mapbox Dataset',
]);
```

**Delete a Dataset:**

```php
Mapbox::datasets($dataset_id)->delete();
```

### Features

[Mapbox documentation.](https://docs.mapbox.com/api/maps/#list-features)

**List Features:**

```php
$features = Mapbox::datasets($dataset_id)->features()->list();
// or
$features = Mapbox::features($dataset_id)->list();
```

**Retrieve a Feature:**

```php
$feature = Mapbox::datasets($dataset_id)->features($feature_id)->get();
// or
$feature = Mapbox::features($dataset_id, $feature_id)->get();
```

**Create or update a Feature:**

```php
$feature = Mapbox::datasets($dataset_id)->features()->add($feature);
// or
$feature = Mapbox::features($dataset_id)->add($feature);
```

**Delete a Feature:**

```php
Mapbox::datasets($dataset_id)->features($feature_id)->delete();
// or
Mapbox::features($dataset_id, $feature_id)->delete();
```

### Tilesets

[Mapbox documentation.](https://docs.mapbox.com/api/maps/#tilesets)

**List Tilesets:**

```php
$tilesets = Mapbox::tilesets()->list();
```

### Uploads

[Mapbox documentation.](https://docs.mapbox.com/api/maps/#uploads)

[Work in progress.]

<!-- **Get S3 Credentials:**
```
// Returns S3Credentials Object
$response = Mapbox::uploads()->credentials();
```

**Create Upload:**
```
$response = Mapbox::uploads()->create([
	'tileset' => '{username}.mytilesetid',
	'url' => 'mapbox://datasets/{username}/{dataset}', // Or S3 Bucket URL from S3Credentials Object
	'name' => 'Upload Name'
]);
```

**Retrieve Upload Status:**
```
$response = Mapbox::uploads($uploadID)->get();
```

**List Upload Statuses:**
```
$list = Mapbox::uploads()->list();
```

**Delete Upload:**
```
$response = Mapbox::uploads($uploadID)->delete();
``` -->

Testing
-------

Before testing the package, create a local `.env.testing` file with valid Mapbox credentials.

```bash
composer test
```

Changelog
---------

See the [CHANGELOG](CHANGELOG.md) for information about what has changed recently.

Security
--------

If you discover any security related issues, please email <jacobtbk@gmail.com> instead of using the issue tracker.

License
-------

This package is licensed under the MIT License (MIT). Please see the [LICENSE](LICENSE.md) for details.

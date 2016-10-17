# PHP Imgur API Client

[![Build Status](https://travis-ci.org/j0k3r/php-imgur-api-client.svg?branch=master)](https://travis-ci.org/j0k3r/php-imgur-api-client)
[![Code Coverage](https://scrutinizer-ci.com/g/j0k3r/php-imgur-api-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/j0k3r/php-imgur-api-client/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/j0k3r/php-imgur-api-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/j0k3r/php-imgur-api-client/?branch=master)

Object Oriented PHP wrapper for the Imgur API.

Uses [Imgur API v3](https://api.imgur.com/).

## Requirements

* PHP >= 5.5
* [Guzzle](https://github.com/guzzle/guzzle) 5

## Composer

Download Composer

```bash
$ curl -s http://getcomposer.org/installer | php
```

Add the library details to your composer.json

```json
"require": {
    "j0k3r/php-imgur-api-client": "^2.0.0"
}
```

Install the dependency with

```bash
$ php composer.phar install
```

## Basic usage

```php
// This file is generated by Composer
require_once 'vendor/autoload.php';

$client = new \Imgur\Client();
$client->setOption('client_id', '[your app client id]');
$client->setOption('client_secret', '[your app client secret]');

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);

    if ($client->checkAccessTokenExpired()) {
          $client->refreshToken();
    }
} elseif (isset($_GET['code'])) {
    $client->requestAccessToken($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
} else {
    echo '<a href="'.$client->getAuthenticationUrl().'">Click to authorize</a>';
}
```

The API calls can be accessed via the `$client` object

```php
$memes = $client->api('memegen')->defaultMemes();
```

## Documentation

This client follow the same tree as the [Imgur API](https://api.imgur.com/endpoints).

Here is the list of available _endpoints_: `account`, `album`, `comment`, `custom gallery`, `gallery`, `image`, `conversation`, `notification`, `memegen` & `topic`.

You can access each endpoint using the `api()` method:

```php
$client->api('album');
$client->api('comment');
$client->api('customGallery');
// etc ...
```

All available methods for each endpoints are in the folder [Api](lib/Imgur/Api). They mostly follow the description name in the Imgur doc. Here are few examples:

```php
// for "Account Base" in account
$client->api('account')->base();
// for "Account Gallery Profile" in account
$client->api('account')->accountGalleryProfile();

// for "Filtered Out Gallery" in Custom Gallery
$client->api('customGallery')->filtered();

// for "Random Gallery Images" in gallery
$client->api('gallery')->randomGalleryImages();

// etc ...
```

If you want to **upload an image** you can use one of these solutions:

```php
$pathToFile = '../path/to/file.jpg';
$imageData = [
    'image' => $pathToFile,
    'type'  => 'file',
];

$client->api('image')->upload($imageData);
```

or


```php
$pathToFile = 'http://0.0.0.0/path/to/file.jpg';
$imageData = [
    'image' => $urlToFile,
    'type'  => 'url',
];

$client->api('image')->upload($imageData);
```

or


```php
$pathToFile = '../path/to/file.jpg';
$imageData = [
    'image' => base64_encode(file_get_contents($pathToFile)),
    'type'  => 'base64',
];

$client->api('image')->upload($imageData);
```

And about the **pagination**, for any API call that supports pagination and is not explicitly available via the method parameters, it can be achieved by using the `BasicPager` object and passing it as the second parameter in the `api()` call.

```php
$pager = new \Imgur\Pager\BasicPager(0, 1);
$images = $client->api('account', $pager)->images();
```

## License

`php-imgur-api-client` is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

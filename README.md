<h1 align="center">Ominity API client for PHP</h1>

## Requirements ##
To use the Ominity API client, the following things are required:

+ PHP >= 7.0
+ Up-to-date OpenSSL (or other SSL/TLS toolkit)

## Installation ##
### Using Composer ###

The easiest way to install the Ominity API client is by using [Composer](http://getcomposer.org/doc/00-intro.md). You can require it with the following command:

```bash
composer require ominity/ominity-api-php
```

### Manual Installation ###
If you're not familiar with using composer we've added a ZIP file to the releases containing the API client and all the packages normally installed by composer.
Download the ``ominity-api-php.zip`` from the [releases page](https://github.com/ominity/ominity-api-php/releases).

Include the ``vendor/autoload.php``

## Usage ##

Initializing the Ominity API client, and setting your endpoint and API key.

```php
$ominity = new \Ominity\Api\OminityApiClient();
$ominity->setApiEndpoint("https://ominity.example.com/api");
$ominity->setApiKey("q48fd94qs98fd4sqf89fza9sqd89f4");
```

With the `OminityApiClient` you can now access any of the following endpoints by selecting them as a property of the client:

### Enabling debug mode ###

When troubleshooting, it can be highly beneficial to have access to the submitted request within the `ApiException`. To safeguard against inadvertently exposing sensitive request data in your local application logs, the debugging feature is initially turned off.

To enable debugging and inspect the request:

```php
/** @var $ominity \Ominity\Api\OminityApiClient */
$ominity->enableDebugging();

try {
    $ominity->commerce->products->get(1);
} catch (\Ominity\Api\Exceptions\ApiException $exception) {
    $request = $exception->getRequest();
}
```

If you are recording instances of `ApiException`, the request details will be included in the logs. It is vital to ensure that no sensitive information is retained within these logs and to perform cleanup after debugging is complete.

To disable debugging again:

```php
/** @var $ominity \Ominity\Api\OminityApiClient */
$ominity->disableDebugging();
```

## License ##
[BSD (Berkeley Software Distribution) License](https://opensource.org/licenses/bsd-license.php).
Copyright (c) 2024, Ominity
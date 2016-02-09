# phpspec Silex Extension

[phpspec](http://www.phpspec.net/) Extension for testing [Silex](http://http://silex.sensiolabs.org//)
applications.

## Installation

Add this to your `composer.json`:

```json
{
    "require": {
        "lasotaartur/phpspec-silex": "dev-master"
    }
}
```

then add this to your `phpspec.yml`:

```yaml
extensions:
    - PhpSpec\Silex\Extension\SilexExtension
```

## Why this extension?

This extension provides you with a bootstrapped Silex environment when writing
your phpspec tests.

## Configuration

in your `phpspec.yml`.

### App bootstrap path

By default, the extension will bootstrap your app by looking for `app/bootstrap.php`. 

You can manually specify the path to the bootstrap file, like so:

```yaml
laravel_extension:
    bootstrap_path: "/your/path/bootstrap.php"
```

**Example of bootstrap.php**

```php
<?php

$app = new Silex\Application();

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});

return $app;

```

## Usage

If you want use silex $app extend your specs
from `PhpSpec\Silex\SilexObjectBehavior`.

**Example**

```php
<?php
namespace spec;

use PhpSpec\Silex\SilexObjectBehavior;

class ProductSpec extends SilexObjectBehavior
{
    function it_let()
    {
        $this->app #this is silex application
    }
}
```

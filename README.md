# Utopia Balancing

Utopia Balancing library is simple and lite library for balancingchoices between multiple options. This library is aiming to be as simple and easy to learn and use. This library is maintained by the [Appwrite team](https://appwrite.io).

Although this library is part of the [Utopia Framework](https://github.com/utopia-php/framework) project it is dependency free and can be used as standalone with any other PHP project or framework.

## Getting Started

Install using composer:
```bash
composer require utopia-php/balancing
```

```php
<?php

require_once '../vendor/autoload.php';

use Utopia\Balancing\Algorithm\RoundRobin;
use Utopia\Balancing\Balancing;
use Utopia\Balancing\Option;

$balancing = new Balancing(new RoundRobin());

$balancing->addFilter(fn (Option $option) => $option->getState('online', false) === true);

$balancing
    ->addOption(new Option([ 'hostname' => 'proxy-1', 'online' => true ]))
    ->addOption(new Option([ 'hostname' => 'proxy-2', 'online' => false ]))
    ->addOption(new Option([ 'hostname' => 'proxy-3', 'online' => true ]));

var_dump($balancing->run());
var_dump($balancing->run());
var_dump($balancing->run());
```

Balancing supports multiple algorithms. Each picks option differently, and may have different set of methods available for configuration.

## System Requirements

Utopia Framework requires PHP 8.0 or later. We recommend using the latest PHP version whenever possible.

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
# Utopia Balancing

[![Build Status](https://github.com/utopia-php/balancing/actions/workflows/tester.yml/badge.svg)
![Total Downloads](https://img.shields.io/packagist/dt/utopia-php/database.svg)
[![Discord](https://img.shields.io/discord/564160730845151244?label=discord)](https://appwrite.io/discord)

Utopia Balancing library is simple and lite library for balancingchoices between multiple options. This library is aiming to be as simple and easy to learn and use. This library is maintained by the [Appwrite team](https://appwrite.io).

Although this library is part of the [Utopia Framework](https://github.com/utopia-php/framework) project it is dependency free and can be used as standalone with any other PHP project or framework.

## Getting Started

Install using composer:
```bash
composer require utopia-php/balancing
```

Balancing supports multiple algorithms. Each picks option differently, and may have different set of methods available for configuration.

### 1. Random

`Random` algorithm pick option randomly. The same option could be picked multiple times in a row. Example:

```php
<?php

require_once '../vendor/autoload.php';

use Utopia\Balancing\Algorithm\Random;
use Utopia\Balancing\Balancing;
use Utopia\Balancing\Option;

$balancing = new Balancing(new Random());

$balancing->addFilter(fn (Option $option) => $option->getState('online', false) === true);

$balancing
    ->addOption(new Option([ 'hostname' => 'proxy-1', 'online' => true ]))
    ->addOption(new Option([ 'hostname' => 'proxy-2', 'online' => false ]))
    ->addOption(new Option([ 'hostname' => 'proxy-3', 'online' => true ]));

var_dump($balancing->run());
var_dump($balancing->run());
var_dump($balancing->run());
```

2. First and Last

`First` algorithm always picks first option. Similiarly, `Last` algorithm always picks last option. Example:

```php
<?php

require_once '../vendor/autoload.php';

use Utopia\Balancing\Algorithm\First;
use Utopia\Balancing\Algorithm\Last;
use Utopia\Balancing\Balancing;
use Utopia\Balancing\Option;

$balancing = new Balancing(new First());

$balancing
    ->addOption(new Option([ 'runtime' => 'PHP' ]))
    ->addOption(new Option([ 'runtime' => 'JavaScript' ]))
    ->addOption(new Option([ 'runtime' => 'Java' ]));

var_dump($balancing->run());

$balancing = new Balancing(new Last());

$balancing
    ->addOption(new Option([ 'runtime' => 'PHP' ]))
    ->addOption(new Option([ 'runtime' => 'JavaScript' ]))
    ->addOption(new Option([ 'runtime' => 'Java' ]));

var_dump($balancing->run());
```

3. Round Robin

`RoundRobin` algorithm cycles over all options starting first. Once algorithm cycles over all options, it resets back to the beginning. Example:

```php
<?php

require_once '../vendor/autoload.php';

use Utopia\Balancing\Algorithm\RoundRobin;
use Utopia\Balancing\Balancing;
use Utopia\Balancing\Option;

$balancing = new Balancing(new RoundRobin(-1));

$balancing->addFilter(fn (Option $option) => $option->getState('online', false) === true);

$balancing
    ->addOption(new Option([ 'dataCenter' => 'fra-1' ]))
    ->addOption(new Option([ 'dataCenter' => 'fra-2' ]))
    ->addOption(new Option([ 'dataCenter' => 'lon-1' ]));

var_dump($balancing->run()); // fra-1
var_dump($balancing->run()); // fra-2
var_dump($balancing->run()); // lon-1
var_dump($balancing->run()); // fra-1
var_dump($balancing->run()); // fra-2
```

When using `RoundRobin` in concurrency model, make sure to store index in atomic way. Example:

```php

require_once '../vendor/autoload.php';

use Utopia\Balancing\Algorithm\RoundRobin;
use Utopia\Balancing\Balancing;
use Utopia\Balancing\Option;

$atomic = new Atomic(-1); // Some atomic implementation, for example: https://openswoole.com/docs/modules/swoole-atomic

function onRequest() {
    $lastIndex = $atomic->get();
    $algo = new RoundRobin($lastIndex);
    $balancing = new Balancing();

    $balancing->addFilter(fn (Option $option) => $option->getState('online', false) === true);

    $balancing
        ->addOption(new Option([ 'dataCenter' => 'fra-1' ]))
        ->addOption(new Option([ 'dataCenter' => 'fra-2' ]))
        ->addOption(new Option([ 'dataCenter' => 'lon-1' ]));

    var_dump($balancing->run());

    $atomic->cmpset($lastIndex, $algo->getIndex());
}
```
## System Requirements

Utopia Framework requires PHP 8.0 or later. We recommend using the latest PHP version whenever possible.

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
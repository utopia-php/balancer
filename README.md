# balancing

## Example

```php
<?php

$cache = new Cache(new Redis()); // Uses utopia-php/cache - allows many adapters

$algo = new Random();
$algo = new RoundRobin();
$algo = new CPU();

$balancing = new Balancing($cache, $algo, 10000);

$health = new HTTP('/v1/health');

$balancing
    ->addHost(new Host('executor-001', $health))
    ->addHost(new Host('executor-002', $health))
    ->addHost(new Host('executor-003', $health));

$extra = [ 'containerId' => 'project1-function1' ];
$balancing->run($extra);

// TODO: Prepare filters (such as Filter/Online, Filter/HighCPU, ...), and see how to add them to algos
```
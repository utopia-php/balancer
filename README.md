# balancing

## Example

```php
<?php

$cpu = new CPU();

$cpu
    ->setHostPriority(0.3)
    ->setVirtualPriority(0.6);

$balancing = new Balancing($algo);

$balancing->addFilter(fn(Option $option) => $option->getState('cpu', 0) < 80);

$balancing
    ->addOption(new Option([ 'cpu' => 99 ]))
    ->addOption(new Option([ 'cpu' => 20 ]))
    ->addOption(new Option([ 'cpu' => 65 ]))
    ->run();
```
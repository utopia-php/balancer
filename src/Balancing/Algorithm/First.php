<?php

namespace Utopia\Balancing\Algorithm;

use Utopia\Balancing\Algorithm;
use Utopia\Balancing\Option;

class First extends Algorithm
{
    /**
     * @param Option[] $options
     */
    public function run(array $options): ?Option
    {
        return $options[0] ?? null;
    }
}

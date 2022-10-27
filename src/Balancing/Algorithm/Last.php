<?php

namespace Utopia\Balancing\Algorithm;

use Utopia\Balancing\Algorithm;
use Utopia\Balancing\Option;

class Last extends Algorithm
{
    /**
     * @param Option[] $options
     */
    public function run(array $options): ?Option
    {
        return $options[\count($options) - 1] ?? null;
    }
}

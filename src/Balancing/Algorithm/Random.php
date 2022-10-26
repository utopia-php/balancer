<?php

namespace Utopia\Balancing\Algorithm;

use Utopia\Balancing\Algorithm;
use Utopia\Balancing\Option;

class Random extends Algorithm
{
    /**
     * @param Option[] $options
     */
    public function run(array $options): Option
    {
        // TODO: Pick random (from $options)
        return $options[0];
    }
}

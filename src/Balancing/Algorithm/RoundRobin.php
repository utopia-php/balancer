<?php

namespace Utopia\Balancing\Algorithm;

use Utopia\Balancing\Algorithm;
use Utopia\Balancing\Option;

class RoundRobin extends Algorithm
{
    private int $index = 0;

    /**
     * @param Option[] $options
     */
    public function run(array $options): ?Option
    {
        $keys = \array_keys($options);

        $option = null;

        if (\count($options) === $this->index) {
            $option = $options[$keys[0]];
            $this->index = 1;
        } else {
            $option = $options[$keys[$this->index]];
            $this->index++;
        }

        return $option;
    }
}

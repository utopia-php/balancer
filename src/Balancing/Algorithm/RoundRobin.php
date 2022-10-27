<?php

namespace Utopia\Balancing\Algorithm;

use Utopia\Balancing\Algorithm;
use Utopia\Balancing\Option;

class RoundRobin extends Algorithm
{
    public function getName(): string
    {
        return "RoundRobin";
    }

    private int $index;

    public function __construct(int $lastIndex)
    {
        $this->index = $lastIndex;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * @param Option[] $options
     */
    public function run(array $options): ?Option
    {
        $this->index++;

        $keys = \array_keys($options);
        $option = null;

        if (\count($options) === $this->index) {
            $option = $options[$keys[0]];
            $this->index = 0;
        } else {
            $option = $options[$keys[$this->index]];
        }

        return $option;
    }
}

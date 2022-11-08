<?php

namespace Utopia\Balancer\Algorithm;

use Utopia\Balancer\Algorithm;
use Utopia\Balancer\Option;

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

    public function setIndex(int $lastIndex): self
    {
        $this->index = $lastIndex;
        return $this;
    }

    /**
     * @param Option[] $options
     */
    public function run(array $options): ?Option
    {
        $this->index++;

        $option = null;

        if (\count($options) === $this->index) {
            $option = $options[0];
            $this->index = 0;
        } else {
            $option = $options[$this->index];
        }

        return $option;
    }
}

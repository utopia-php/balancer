<?php

namespace Utopia\Balancing;

abstract class Algorithm
{
    /**
     * @param Option[] $options
     */
    abstract public function run(array $options): ?Option;
}

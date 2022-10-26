<?php

namespace Utopia\Balancing;

abstract class Health
{
    /**
     * @return ?mixed[]
     */
    abstract public function run(Host $host): ?array;
}

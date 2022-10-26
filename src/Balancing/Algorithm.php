<?php

namespace Utopia\Balancing;

abstract class Algorithm
{
    /**
     * @param Host[] $hosts
     * @param ?mixed[] $extra
     */
    abstract public function run(array $hosts, ?array $extra): Host;
}

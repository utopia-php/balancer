<?php

namespace Utopia\Balancing\Algorithm;

use Utopia\Balancing\Algorithm;
use Utopia\Balancing\Host;

class Random extends Algorithm
{
    /**
     * @param Host[] $hosts
     * @param ?mixed[] $extra
     */
    public function run(array $hosts, ?array $extra): Host
    {
        // TODO: Pick random (from $hosts)
        return $hosts[0];
    }
}

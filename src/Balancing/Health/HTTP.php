<?php

namespace Utopia\Balancing\Health;

use Utopia\Balancing\Health;
use Utopia\Balancing\Host;

class HTTP extends Health
{
    private string $endpoint;

    public function __construct(string $endpoint = '/')
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return ?mixed[]
     */
    public function run(Host $host): ?array
    {
        $url = $this->endpoint . $host->getHostname();
        // TODO: Send HTTP request
        return null;
    }
}

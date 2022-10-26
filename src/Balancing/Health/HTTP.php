<?php

class HTTP extends Health {
    private string $endpoint;

    function __construct(string $endpoint = '/') {
        $this->endpoint = $endpoint;
    }

    function run(Host $host): mixed {
        // TODO: Send HTTP request (to $this->endpoint and $host->getHostname())
        return null;
    }
}
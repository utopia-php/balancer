<?php

class HTTP extends Health {
    private string $endpoint;

    function __construct(string $endpoint = '/') {
        $this->endpoint = $endpoint;
    }

    // Simple, configurable, unopinionated (response format)
    function run(Host $host): mixed {
        // HTTP request
        return null;
    }
}
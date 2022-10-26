<?php

class Host {
    private string $hostname;
    private Health $health;

    private bool $online;
    private mixed $state;

    public function __construct(String $hostname, Health $health) {
        $this->hostname = $hostname;
        $this->health = $health;
    }

    public function fetchHealth(): void {
        $state = $this->health->run($this);

        $this->state = $state;
        $this->online = $state !== null;
    }

    public function getOnline(): bool {
        return $this->online;
    }

    public function getState(): mixed {
        return $this->state;
    }
}
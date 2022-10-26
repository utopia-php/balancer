<?php

namespace Utopia\Balancing;

class Host
{
    private string $hostname;

    private ?Health $health;

    private bool $online = false;

    /**
     * @var mixed[]
     */
    private array $state = [];

    public function __construct(string $hostname, ?Health $health)
    {
        $this->hostname = $hostname;
        $this->health = $health;
    }

    public function fetchHealth(): void
    {
        if (empty($this->health)) {
            throw new \Exception('Health check not configured.');
        }

        $state = $this->health->run($this);

        $this->state = $state ?? [];
        $this->online = $state !== null;
    }

    public function getOnline(): bool
    {
        return $this->online;
    }

    public function getHealth(): ?Health
    {
        return $this->health;
    }

    /**
     * @return mixed[]
     */
    public function getState(): array
    {
        return $this->state;
    }

    public function getHostname(): string
    {
        return $this->hostname;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    /**
     * @param mixed[] $state
     */
    public function setState(array $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function setHostname(string $hostname): self
    {
        $this->hostname = $hostname;

        return $this;
    }
}

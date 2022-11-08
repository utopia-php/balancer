<?php

namespace Utopia\Balancer;

class Balancer
{
    private Algorithm $algo;

    /**
     * @var callable[]
     */
    private array $filters = [];

    /**
     * @var Option[]
     */
    private array $options = [];

    public function __construct(Algorithm $algo)
    {
        $this->algo = $algo;
    }

    public function getAlgo(): Algorithm
    {
        return $this->algo;
    }

    public function addOption(Option $option): self
    {
        $this->options[] = $option;
        return $this;
    }

    public function addFilter(callable $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    public function run(): ?Option
    {
        $options = $this->options;

        foreach ($this->filters as $filter) {
            $options = \array_filter($options, $filter);
        }

        $options = \array_values($options);

        return $this->algo->run($options);
    }
}

<?php

namespace Utopia\Balancing;

class Balancing
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

        // TODO: In future allow throwing exception instead of fallback
        if (\count($options) === 0) {
            $options = $this->options;
        }

        return $this->algo->run($options);
    }
}

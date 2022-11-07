<?php

namespace Utopia\Balancer;

class Group
{
    /**
     * @var Balancer[]
     */
    protected array $balancers = [];

    /**
     * @param Balancer $balancer
     * @return self
     */
    public function add(Balancer $balancer): self
    {
        $this->balancers[] = $balancer;
        return $this;
    }

    public function run(): ?Option
    {
        $option = null;

        foreach ($this->balancers as $balancer) {
            $option = $balancer->run();

            if ($option !== null) {
                break;
            }
        }

        return $option;
    }
}

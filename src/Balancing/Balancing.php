<?php

class Balancing {
    private Cache $cache;
    private Algorithm $algo;
    
    // @var Host[]
    private array $hosts = [];

    // @param $interval Health check interval in milliseconds. Set to 0 to disable
    public function __construct(Cache $cache, Algorithm $algo, int $interval = 0) {
        $this->cache = $cache;
        $this->algo = $algo;

        if($interval === 0) {
            CLI::loop($interval, function() {
                foreach ($this->hosts as $host) {
                    // TODO: Figure out scaling. If multiple balancers, then one should be pinging, others should get from cache. Ideally allow work to be distributed
                    $host->fetchHealth();

                    $this->cache->set($host, [
                        'online' => $host->getOnline(),
                        'state' => $host->getState()
                    ]);
                }
            });
        }
    }
    
    public function addHost(Host $host): self {
        $this->hosts[] = $host;
        return $this;
    }

    // @param $extra mixed[]
    public function run(array $extra = []): Host {
        return $this->algo->run($this->hosts, $extra);
    }
}
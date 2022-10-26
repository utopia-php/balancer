<?php

namespace Utopia\Balancing;

use Utopia\Cache\Cache;

class Balancing
{
    private ?Cache $cache;

    private Algorithm $algo;

    /**
     * @var Host[]
     */
    private array $hosts = [];

    /**
     * @param $interval Health check interval in milliseconds. Set to 0 to disable
     */
    public function __construct(Algorithm $algo, ?Cache $cache, int $interval = 0)
    {
        $this->cache = $cache;
        $this->algo = $algo;

        if ($interval !== 0) {
            CLI::loop($interval, function () {
                foreach ($this->hosts as $host) {
                    if (! empty($host->getHealth())) {
                        $host->fetchHealth();

                        if (! empty($this->cache)) {
                            $this->cache->save($host->getHostname(), [
                                'online' => $host->getOnline(),
                                'state' => $host->getState(),
                            ]);
                        }
                    } else {
                        if (! empty($this->cache)) {
                            $data = $this->cache->load($host->getHostname(), 60 * 60); // 1 hour

                            $host
                                ->setOnline((bool) ($data['online'] ?? false))
                                ->setState((array) ($data['state'] ?? []));
                        }
                    }
                }
            });
        }
    }

    public function addHost(Host $host): self
    {
        $this->hosts[] = $host;

        return $this;
    }

    /**
     * @param ?mixed[] $extra
     */
    public function run(?array $extra): Host
    {
        return $this->algo->run($this->hosts, $extra);
    }
}

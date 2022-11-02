<?php

namespace Utopia\Tests;

use PHPUnit\Framework\TestCase;
use Utopia\Balancing\Algorithm\First;
use Utopia\Balancing\Algorithm\Last;
use Utopia\Balancing\Algorithm\Random;
use Utopia\Balancing\Algorithm\RoundRobin;
use Utopia\Balancing\Balancing;
use Utopia\Balancing\Option;

class BalancingTest extends TestCase
{
    public function testBalancing(): void
    {
        $balancing = new Balancing(new RoundRobin(-1));

        $this->assertInstanceOf(RoundRobin::class, $balancing->getAlgo());

        $balancing
            ->addOption(new Option(['hostname' => 'worker-1', 'isOnline' => true, 'cpu' => 80]))
            ->addOption(new Option(['hostname' => 'worker-2', 'isOnline' => false, 'cpu' => 20]))
            ->addOption(new Option(['hostname' => 'worker-3', 'isOnline' => true, 'cpu' => 35]));

        $option = $balancing->run() ?? new Option([]);
        $this->assertEquals('worker-1', $option->getState('hostname'));

        $balancing->addFilter(fn ($option) => $option->getState('isOnline') === true);

        $option = $balancing->run() ?? new Option([]);
        $this->assertEquals('worker-3', $option->getState('hostname'));

        $option = $balancing->run() ?? new Option([]);
        $this->assertEquals('worker-1', $option->getState('hostname'));

        $balancing->addFilter(fn ($option) => $option->getState('cpu') < 50);

        $option = $balancing->run() ?? new Option([]);
        $this->assertEquals('worker-3', $option->getState('hostname'));

        $option = $balancing->run() ?? new Option([]);
        $this->assertEquals('worker-3', $option->getState('hostname'));

        $option = $balancing->run() ?? new Option([]);
        $this->assertEquals('worker-3', $option->getState('hostname'));

        $balancing->addOption(new Option(['hostname' => 'worker-4', 'isOnline' => true, 'cpu' => 5]));

        $option = $balancing->run() ?? new Option([]);
        $this->assertEquals('worker-4', $option->getState('hostname'));

        $option = $balancing->run() ?? new Option([]);
        $this->assertEquals('worker-3', $option->getState('hostname'));

        $option = $balancing->run() ?? new Option([]);
        $this->assertEquals('worker-4', $option->getState('hostname'));

        $balancing = new Balancing(new Random());
        $this->assertInstanceOf(Random::class, $balancing->getAlgo());
    }

    public function testAlgorithms(): void
    {
        $options = [
            new Option([ 'dataCenter' => 'fra-1' ]),
            new Option([ 'dataCenter' => 'fra-2' ]),
            new Option([ 'dataCenter' => 'lon-1' ]),
        ];

        $algo = new First();
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("fra-1", $option->getState('dataCenter'));

        $algo = new Last();
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("lon-1", $option->getState('dataCenter'));

        $algo = new Random();
        $option = $algo->run($options) ?? new Option([]);
        $this->assertTrue(\in_array($option->getState('dataCenter'), ['fra-1', 'fra-2', 'lon-1']));
        $this->assertTrue(\in_array($option->getState('dataCenter'), ['fra-1', 'fra-2', 'lon-1']));
        $this->assertTrue(\in_array($option->getState('dataCenter'), ['fra-1', 'fra-2', 'lon-1']));

        $algo = new RoundRobin(-1);
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("fra-1", $option->getState('dataCenter'));
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("fra-2", $option->getState('dataCenter'));
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("lon-1", $option->getState('dataCenter'));
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("fra-1", $option->getState('dataCenter'));
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("fra-2", $option->getState('dataCenter'));
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("lon-1", $option->getState('dataCenter'));
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("fra-1", $option->getState('dataCenter'));

        $algo = new RoundRobin(1);
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("lon-1", $option->getState('dataCenter'));
        $algo->setIndex(0);
        $option = $algo->run($options) ?? new Option([]);
        $this->assertEquals("fra-2", $option->getState('dataCenter'));
    }

    public function testOption(): void
    {
        $option = new Option([]);

        $this->assertIsArray($option->getStates());
        $this->assertCount(0, $option->getStates());

        $this->assertFalse($option->getState("isOnline", false));
        $this->assertNull($option->getState("isOnline"));

        $option->setState("isOnline", true);

        $this->assertTrue($option->getState("isOnline", false));
        $this->assertTrue($option->getState("isOnline"));

        $this->assertNull($option->getState("ISONLINE"));

        $this->assertCount(1, $option->getStates());
        $this->assertEquals(true, $option->getStates()['isOnline']);

        $option
            ->setState('cpu', 50)
            ->setState('memory', 1800);

        $this->assertCount(3, $option->getStates());
        $this->assertEquals(50, $option->getStates()['cpu']);
        $this->assertEquals(1800, $option->getStates()['memory']);
        $this->assertTrue($option->getState("isOnline"));
        $this->assertEquals(50, $option->getState("cpu"));
        $this->assertEquals(1800, $option->getState("memory"));

        $option
            ->deleteState('isOnline')
            ->deleteState('cpu');

        $this->assertCount(1, $option->getStates());
        $this->assertNull($option->getState("isOnline"));
        $this->assertNull($option->getState("cpu"));
        $this->assertEquals(0, $option->getState("cpu", 0));
        $this->assertEquals(1800, $option->getState("memory"));
    }
}

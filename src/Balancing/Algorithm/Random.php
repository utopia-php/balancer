<?php

class Random extends Algorithm {
    // @param $hosts Host[]
    // @param $extra mixed[]
    public function run(array $hosts, array $extra): Host {
        // Pick random
        return $hosts[0];
    }
}
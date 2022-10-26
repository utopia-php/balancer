<?php

class Random extends Algorithm {
    // @param $hosts Host[]
    // @param $extra mixed[]
    public function run(array $hosts, array $extra): Host {
        // TODO: Pick random (from $hosts)
        return $hosts[0];
    }
}
<?php

abstract class Algorithm {
    // @param $hosts Host[]
    // @param $extra mixed[]
    abstract function run(array $hosts, array $extra): Host;
}
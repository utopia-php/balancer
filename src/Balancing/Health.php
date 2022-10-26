<?php

abstract class Health {
    abstract function run(Host $host): mixed;
}
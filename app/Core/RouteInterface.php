<?php

namespace App\Core;

interface RouteInterface
{
    public function add($route, $params): void;
    public function match(): bool;
}

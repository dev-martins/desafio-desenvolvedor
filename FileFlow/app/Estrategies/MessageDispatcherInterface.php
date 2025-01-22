<?php

namespace App\Estrategies;

interface MessageDispatcherInterface
{
    public function dispatch(string $jobClass, array $payload): void;
}

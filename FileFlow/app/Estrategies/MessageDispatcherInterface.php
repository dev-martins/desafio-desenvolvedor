<?php

namespace App\Estrategies;

interface MessageDispatcherInterface
{
    public function dispatch(array $payload, string $jobClass = null): void;
}

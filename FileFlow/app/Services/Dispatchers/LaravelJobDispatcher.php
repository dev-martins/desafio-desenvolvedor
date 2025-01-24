<?php

namespace App\Services\Dispatchers;

use App\Estrategies\MessageDispatcherInterface;

class LaravelJobDispatcher implements MessageDispatcherInterface
{
    public function dispatch(array $payload, string $jobClass = null): void
    {
        dispatch(new $jobClass(...$payload));
    }
}

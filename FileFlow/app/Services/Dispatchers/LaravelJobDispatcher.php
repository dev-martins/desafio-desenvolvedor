<?php

namespace App\Services\Dispatchers;

use App\Estrategies\MessageDispatcherInterface;

class LaravelJobDispatcher implements MessageDispatcherInterface
{
    public function dispatch(string $jobClass, array $payload): void
    {
        dispatch(new $jobClass(...$payload));
    }
}

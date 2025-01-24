<?php

namespace App\Factories;

use App\Estrategies\MessageDispatcherInterface;
use App\Services\Dispatchers\LaravelJobDispatcher;
use App\Services\Dispatchers\RabbitMQDispatcher;

class DispatcherFactory
{
    public static function make(): MessageDispatcherInterface
    {
        $type = config('queue.dispatcher', 'laravel');

        return match ($type) {
            'rabbitmq' => new RabbitMQDispatcher(
                env('RABBITMQ_HOST'),
                env('RABBITMQ_PORT'),
                env('RABBITMQ_USER'),
                env('RABBITMQ_PASSWORD'),
                env('VHOST'),
                env('RABBITMQ_QUEUE')
            ),
            default => new LaravelJobDispatcher(),
        };
    }
}

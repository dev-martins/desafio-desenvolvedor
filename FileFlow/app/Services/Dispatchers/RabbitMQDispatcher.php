<?php

namespace App\Services\Dispatchers;

use App\Estrategies\MessageDispatcherInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQDispatcher implements MessageDispatcherInterface
{
    protected $connection;
    protected $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD')
        );
        $this->channel = $this->connection->channel();
    }

    public function dispatch(string $jobClass, array $payload): void
    {
        $this->channel->queue_declare(env('RABBITMQ_QUEUE'), false, true, false, false);

        $message = new AMQPMessage(json_encode([
            'job' => $jobClass,
            'data' => $payload,
        ]));

        $this->channel->basic_publish($message, '', env('RABBITMQ_QUEUE'));
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

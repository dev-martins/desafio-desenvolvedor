<?php

namespace App\Services\Dispatchers;

namespace App\Services\Dispatchers;

use App\Estrategies\MessageDispatcherInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

class RabbitMQDispatcher implements MessageDispatcherInterface
{
    protected $connection;
    protected $channel;
    protected $queue;

    public function __construct(
        string $host,
        int $port,
        string $user,
        string $password,
        string $vhost,
        string $queue
    ) {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
        $this->channel = $this->connection->channel();
        $this->queue = $queue;

        $this->channel->queue_declare(
            $this->queue,
            false,
            true,
            false,
            false,
            false,
            new AMQPTable([
                'x-message-ttl' => 10000,
                'x-dead-letter-exchange' => 'dlx-exchange',
                'x-dead-letter-routing-key' => 'file-process-dlx'
            ])
        );
    }

    public function dispatch(array $payload, string $jobClass = null): void
    {
        $message = new AMQPMessage(json_encode([
            'data' => $payload,
        ]));

        $this->channel->basic_publish($message, '', $this->queue);
    }

    public function __destruct()
    {
        if ($this->channel) {
            $this->channel->close();
        }
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

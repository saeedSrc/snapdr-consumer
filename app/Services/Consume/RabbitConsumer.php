<?php

namespace App\Services\Consume;

use ErrorException;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitConsumer implements ConsumeInterface
{
    private AMQPChannel $channel;
    private AMQPStreamConnection $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->connection = AMQPStreamConnection::create_connection($this->getConn());
        $this->channel = $this->connection->channel();
    }

    private function getConn(): array
    {
        return [
            [
                'host' => env('RABBITMQ_HOST'),
                'port' => env('RABBITMQ_PORT'),
                'user' => env('RABBITMQ_USERNAME'),
                'password' => env('RABBITMQ_PASSWORD'),
            ]
        ];
    }

    public function getChannel(): AMQPChannel
    {
        return $this->channel;
    }

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    private function declareQueue(string $queueName): void
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
    }

    private function bindQueue(string $queueName, string $exchange = '', string $type = AMQPExchangeType::DIRECT): void
    {
        $this->channel->exchange_declare($queueName, $type, false, true, false);
        $this->channel->queue_bind($queueName, $exchange);
    }

    /**
     * @throws ErrorException
     */
    public function consume(
        string $queueName,
        string $consumerTag,
        callable $callback,
        string $exchange = '',
        string $type = AMQPExchangeType::DIRECT
    ): void {
        $this->declareQueue($queueName);
        if ($consumerTag !== '') {
            $this->bindQueue($queueName, $exchange, $type);
        }
        $this->channel->basic_consume(
            $queueName,
            $consumerTag,
            callback: function (AMQPMessage $message) use ($callback) {
                $callback($message->body);
                $message->ack();
            }
        );
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}

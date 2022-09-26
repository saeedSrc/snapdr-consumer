<?php

namespace App\Services\Consume;

interface ConsumeInterface
{
    public function consume(
        string $queueName,
        string $consumerTag,
        callable $callback,
        string $exchange = '',
        string $type = 'default'
    ): void;
}

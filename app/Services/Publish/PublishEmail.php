<?php

namespace App\Services\Publish;

use App\Builder\NotificationBuilderInterface;
use Throwable;

class PublishEmail implements NotificationBuilderInterface
{
    public function push(string $to, string $name, string $message): void
    {
        try {
            mail($to, "Dear $name", $message);
        } catch (Throwable) {
        }
    }
}

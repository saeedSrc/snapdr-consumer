<?php

namespace App\Domain;

class Notification
{
    public function __construct(
        private string $to,
        private string $name,
        private string $message,
        private string $messageKey
    ) {
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getMessageKey(): string
    {
        return $this->messageKey;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

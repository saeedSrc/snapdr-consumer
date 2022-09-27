<?php

namespace App\Domain;

class Notification
{
    public function __construct(
        private string $to,
        private string $name,
        private string $message,
        private string $key
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

    public function getKey(): string
    {
        return $this->key;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

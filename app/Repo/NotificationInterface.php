<?php

namespace App\Repo;

interface NotificationInterface
{
    public function UpdateToSuccessReceived(string $messageKey): void;
}

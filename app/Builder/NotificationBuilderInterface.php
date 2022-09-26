<?php

namespace App\Builder;

interface NotificationBuilderInterface
{
   public function push(string $to, string $name, string $message): void;
}

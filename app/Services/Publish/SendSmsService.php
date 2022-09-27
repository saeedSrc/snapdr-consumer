<?php

namespace App\Services\Publish;

use App\Builder\NotificationBuilderInterface;
use GuzzleHttp\Client;
use Throwable;

class SendSmsService implements NotificationBuilderInterface
{
    public function push(string $to, string $name, string $message): void
    {
        $client = new Client();
        try {
            $client->request('POST', 'https://www.sendsms.com', [
                'form_params' => [
                    'to' => $to,
                    'message' => $message,
                    'name' => $name
                ],
                'connect_timeout' => 1
            ]);
        } catch (Throwable) {
        }
    }
}

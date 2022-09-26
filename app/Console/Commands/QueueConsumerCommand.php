<?php

namespace App\Console\Commands;


use App\Builder\NotificationBuilder;
use App\Builder\NotificationDirector;
use App\Domain\Notification;
use App\Services\Consume\ConsumeInterface;
use App\Services\Publish\PublishEmail;
use App\Services\Publish\PublishSms;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use stdClass;

class QueueConsumerCommand extends Command
{
    private const MESSAGE_TYPE_SMS = 'sms';
    private const MESSAGE_TYPE_EMAIL = 'email';

    protected $signature = 'queue:consume';

    protected $description = 'This command consumes the rabbitmq';

    public function __construct(private ConsumeInterface $queueManager)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->info('consuming...');

        $this->queueManager->consume('notifications', '', function (string $messageBody) {
            $this->publish(json_decode($messageBody));
        });
    }

    /**
     * @param stdClass $message
     * @throws BindingResolutionException
     */
    private function publish(stdClass $message): void
    {
        $type = $message->type;
        $notifiable = new Notification(
            $message->to,
            $message->name,
            $message->message,
            $message->key
        );
        switch ($type) {
            case self::MESSAGE_TYPE_EMAIL:
                (new NotificationDirector())->build(new PublishEmail(), new NotificationBuilder($notifiable->getTo(), $notifiable->$this->getName(), $notifiable->getMessage()));
                break;
            case self::MESSAGE_TYPE_SMS:
                (new NotificationDirector())->build(new PublishSms(), new NotificationBuilder($notifiable->getTo(), $notifiable->$this->getName(), $notifiable->getMessage()));
                break;
            case 2:
                throw new InvalidArgumentException();
                break;
        }

    }
}

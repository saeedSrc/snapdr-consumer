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
    protected $description = 'this is rabbit mq consumer that is consuming notifications...';
    protected $signature = 'queue:consume';

    private const EMAIL_SUBJECT = 'email';
    private const SMS_SUBJECT = 'sms';


    public function __construct(private ConsumeInterface $queueManager)
    {
        parent::__construct();
    }

    public function handle(): void
    {
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
        $notif = new Notification(
            $message->to,
            $message->name,
            $message->message,
            $message->key
        );

        // default
        $methodType = new PublishEmail();
        $methodBuilder = new NotificationBuilder($notif->getTo(), $notif->$this->getName(), $notif->getMessage());
        switch ($type) {
            case self::EMAIL_SUBJECT:
                break;
            case self::SMS_SUBJECT:
                $methodType = new PublishSms();
                break;
            default:
                throw new InvalidArgumentException();
        }

        (new NotificationDirector())->build($methodType, $methodBuilder);

    }
}

<?php

namespace App\Actions;

use Consumer\Factories\NotificationServiceCreator;
use Consumer\Repositories\NotificationRepositoryInterface;
use Consumer\ValueObjects\Notifiable;

class Push
{
    private ?NotificationServiceCreator $notificationServiceCreator;

    public function __construct(private NotificationRepositoryInterface $notificationRepository)
    {
    }

    public function setNotificationServiceCreator(
        ?NotificationServiceCreator $notificationServiceCreator,
    ): SendNotificationAction {
        $this->notificationServiceCreator = $notificationServiceCreator;

        return $this;
    }

    public function __invoke(Notifiable $notifiable): void
    {
        $this->notificationServiceCreator?->handle($notifiable);
        $this->notificationRepository->updateByMessageKeyAndSetAsSent($notifiable->getMessageKey());
    }
}

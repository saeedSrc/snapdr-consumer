<?php

namespace App\Listeners;

use App\Events\MessagePublished;
use App\Repo\NotificationInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateSuccessReceived
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(private NotificationInterface $notificationRepository)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MessagePublished  $event
     * @return void
     */
    public function handle(MessagePublished $event)
    {
        $this->notificationRepository->UpdateToSuccessReceived( $event->notification->getKey());
    }
}

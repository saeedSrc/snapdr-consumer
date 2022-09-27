<?php

namespace App\Providers;

use App\Repo\MysqlRepo\Notification;
use App\Repo\NotificationInterface;
use App\Services\Consume\ConsumeInterface;
use App\Services\Consume\RabbitConsumer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ConsumeInterface::class, RabbitConsumer::class);
        $this->app->bind(NotificationInterface::class, Notification::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\UserCreated;
use App\Listeners\HandleUserAddress;
class EventServiceProvide extends ServiceProvider
{

    protected $listen = [
        UserCreated::class => [
            HandleUserAddress::class,
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

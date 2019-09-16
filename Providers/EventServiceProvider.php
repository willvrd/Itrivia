<?php

namespace Modules\Itrivia\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Itrivia\Events\TriviaWasCreated;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TriviaWasCreated::class => [
        ]
    ];
}
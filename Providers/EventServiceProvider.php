<?php

namespace Modules\Itrivia\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Itrivia\Events\TriviaWasCreated;

use Modules\Itrivia\Events\UserTriviaWasCreated;
use Modules\Itrivia\Events\Handlers\CheckQuestionsAnswers;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TriviaWasCreated::class => [
        ],
        UserTriviaWasCreated::class => [
            CheckQuestionsAnswers::class,
        ]
    ];
}
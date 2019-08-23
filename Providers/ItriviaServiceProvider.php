<?php

namespace Modules\Itrivia\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Itrivia\Events\Handlers\RegisterItriviaSidebar;

class ItriviaServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterItriviaSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('trivias', array_dot(trans('itrivia::trivias')));
            $event->load('questions', array_dot(trans('itrivia::questions')));
            $event->load('answers', array_dot(trans('itrivia::answers')));
            $event->load('userquestionanswers', array_dot(trans('itrivia::userquestionanswers')));
            $event->load('usertrivias', array_dot(trans('itrivia::usertrivias')));
            $event->load('rangepoints', array_dot(trans('itrivia::rangepoints')));
            // append translations






        });
    }

    public function boot()
    {
        $this->publishConfig('itrivia', 'permissions');
        $this->publishConfig('itrivia', 'settings');
        $this->publishConfig('itrivia', 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Itrivia\Repositories\TriviaRepository',
            function () {
                $repository = new \Modules\Itrivia\Repositories\Eloquent\EloquentTriviaRepository(new \Modules\Itrivia\Entities\Trivia());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Itrivia\Repositories\Cache\CacheTriviaDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Itrivia\Repositories\QuestionRepository',
            function () {
                $repository = new \Modules\Itrivia\Repositories\Eloquent\EloquentQuestionRepository(new \Modules\Itrivia\Entities\Question());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Itrivia\Repositories\Cache\CacheQuestionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Itrivia\Repositories\AnswerRepository',
            function () {
                $repository = new \Modules\Itrivia\Repositories\Eloquent\EloquentAnswerRepository(new \Modules\Itrivia\Entities\Answer());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Itrivia\Repositories\Cache\CacheAnswerDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Itrivia\Repositories\UserQuestionAnswerRepository',
            function () {
                $repository = new \Modules\Itrivia\Repositories\Eloquent\EloquentUserQuestionAnswerRepository(new \Modules\Itrivia\Entities\UserQuestionAnswer());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Itrivia\Repositories\Cache\CacheUserQuestionAnswerDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Itrivia\Repositories\UserTriviaRepository',
            function () {
                $repository = new \Modules\Itrivia\Repositories\Eloquent\EloquentUserTriviaRepository(new \Modules\Itrivia\Entities\UserTrivia());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Itrivia\Repositories\Cache\CacheUserTriviaDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Itrivia\Repositories\RangePointRepository',
            function () {
                $repository = new \Modules\Itrivia\Repositories\Eloquent\EloquentRangePointRepository(new \Modules\Itrivia\Entities\RangePoint());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Itrivia\Repositories\Cache\CacheRangePointDecorator($repository);
            }
        );
// add bindings






    }
}

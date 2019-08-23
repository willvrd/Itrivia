<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/trivias'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.itrivia.trivias.create',
    'uses' => 'TriviaApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.itrivia.trivias.index',
    'uses' => 'TriviaApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.itrivia.trivias.update',
    'uses' => 'TriviaApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.itrivia.trivias.delete',
    'uses' => 'TriviaApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.itrivia.trivias.show',
    'uses' => 'TriviaApiController@show',
  ]);

});
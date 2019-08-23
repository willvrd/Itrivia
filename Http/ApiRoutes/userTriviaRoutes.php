<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/user-trivias'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.itrivia.user-trivias.create',
    'uses' => 'UserTriviaApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.itrivia.user-trivias.index',
    'uses' => 'UserTriviaApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.itrivia.user-trivias.update',
    'uses' => 'UserTriviaApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.itrivia.user-trivias.delete',
    'uses' => 'UserTriviaApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.itrivia.user-trivias.show',
    'uses' => 'UserTriviaApiController@show',
  ]);

});
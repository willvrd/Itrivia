<?php

use Illuminate\Routing\Router;

/**
 * Testing 'middleware' => ['auth:api'] - error
 * Testing 'middleware' => ['api.token']
 */

$router->group(['prefix' => '/answers','middleware' => ['api.token']], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.itrivia.answers.create',
    'uses' => 'AnswerApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.itrivia.answers.index',
    'uses' => 'AnswerApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.itrivia.answers.update',
    'uses' => 'AnswerApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.itrivia.answers.delete',
    'uses' => 'AnswerApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.itrivia.questions.show',
    'uses' => 'AnswerApiController@show',
  ]);

});
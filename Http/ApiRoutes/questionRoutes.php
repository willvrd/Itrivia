<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/questions'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.itrivia.questions.create',
    'uses' => 'QuestionApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.itrivia.questions.index',
    'uses' => 'QuestionApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.itrivia.questions.update',
    'uses' => 'QuestionApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.itrivia.questions.delete',
    'uses' => 'QuestionApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.itrivia.questions.show',
    'uses' => 'QuestionApiController@show',
  ]);

});
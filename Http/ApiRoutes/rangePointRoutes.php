<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/range-points'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.itrivia.range-points.create',
    'uses' => 'RangePointApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.itrivia.range-points.index',
    'uses' => 'RangePointApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.itrivia.range-points.update',
    'uses' => 'RangePointApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.itrivia.range-points.delete',
    'uses' => 'RangePointApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.itrivia.range-points.show',
    'uses' => 'RangePointApiController@show',
  ]);

});
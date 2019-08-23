<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/itrivia'], function (Router $router) {
    $router->bind('trivia', function ($id) {
        return app('Modules\Itrivia\Repositories\TriviaRepository')->find($id);
    });
    $router->get('trivias', [
        'as' => 'admin.itrivia.trivia.index',
        'uses' => 'TriviaController@index',
        'middleware' => 'can:itrivia.trivias.index'
    ]);
    $router->get('trivias/create', [
        'as' => 'admin.itrivia.trivia.create',
        'uses' => 'TriviaController@create',
        'middleware' => 'can:itrivia.trivias.create'
    ]);
    $router->post('trivias', [
        'as' => 'admin.itrivia.trivia.store',
        'uses' => 'TriviaController@store',
        'middleware' => 'can:itrivia.trivias.create'
    ]);
    $router->get('trivias/{trivia}/edit', [
        'as' => 'admin.itrivia.trivia.edit',
        'uses' => 'TriviaController@edit',
        'middleware' => 'can:itrivia.trivias.edit'
    ]);
    $router->put('trivias/{trivia}', [
        'as' => 'admin.itrivia.trivia.update',
        'uses' => 'TriviaController@update',
        'middleware' => 'can:itrivia.trivias.edit'
    ]);
    $router->delete('trivias/{trivia}', [
        'as' => 'admin.itrivia.trivia.destroy',
        'uses' => 'TriviaController@destroy',
        'middleware' => 'can:itrivia.trivias.destroy'
    ]);
    $router->bind('question', function ($id) {
        return app('Modules\Itrivia\Repositories\QuestionRepository')->find($id);
    });
    $router->get('questions', [
        'as' => 'admin.itrivia.question.index',
        'uses' => 'QuestionController@index',
        'middleware' => 'can:itrivia.questions.index'
    ]);
    $router->get('questions/create', [
        'as' => 'admin.itrivia.question.create',
        'uses' => 'QuestionController@create',
        'middleware' => 'can:itrivia.questions.create'
    ]);
    $router->post('questions', [
        'as' => 'admin.itrivia.question.store',
        'uses' => 'QuestionController@store',
        'middleware' => 'can:itrivia.questions.create'
    ]);
    $router->get('questions/{question}/edit', [
        'as' => 'admin.itrivia.question.edit',
        'uses' => 'QuestionController@edit',
        'middleware' => 'can:itrivia.questions.edit'
    ]);
    $router->put('questions/{question}', [
        'as' => 'admin.itrivia.question.update',
        'uses' => 'QuestionController@update',
        'middleware' => 'can:itrivia.questions.edit'
    ]);
    $router->delete('questions/{question}', [
        'as' => 'admin.itrivia.question.destroy',
        'uses' => 'QuestionController@destroy',
        'middleware' => 'can:itrivia.questions.destroy'
    ]);
    $router->bind('answer', function ($id) {
        return app('Modules\Itrivia\Repositories\AnswerRepository')->find($id);
    });
    $router->get('answers', [
        'as' => 'admin.itrivia.answer.index',
        'uses' => 'AnswerController@index',
        'middleware' => 'can:itrivia.answers.index'
    ]);
    $router->get('answers/create', [
        'as' => 'admin.itrivia.answer.create',
        'uses' => 'AnswerController@create',
        'middleware' => 'can:itrivia.answers.create'
    ]);
    $router->post('answers', [
        'as' => 'admin.itrivia.answer.store',
        'uses' => 'AnswerController@store',
        'middleware' => 'can:itrivia.answers.create'
    ]);
    $router->get('answers/{answer}/edit', [
        'as' => 'admin.itrivia.answer.edit',
        'uses' => 'AnswerController@edit',
        'middleware' => 'can:itrivia.answers.edit'
    ]);
    $router->put('answers/{answer}', [
        'as' => 'admin.itrivia.answer.update',
        'uses' => 'AnswerController@update',
        'middleware' => 'can:itrivia.answers.edit'
    ]);
    $router->delete('answers/{answer}', [
        'as' => 'admin.itrivia.answer.destroy',
        'uses' => 'AnswerController@destroy',
        'middleware' => 'can:itrivia.answers.destroy'
    ]);
    $router->bind('userquestionanswer', function ($id) {
        return app('Modules\Itrivia\Repositories\UserQuestionAnswerRepository')->find($id);
    });
    $router->get('userquestionanswers', [
        'as' => 'admin.itrivia.userquestionanswer.index',
        'uses' => 'UserQuestionAnswerController@index',
        'middleware' => 'can:itrivia.userquestionanswers.index'
    ]);
    $router->get('userquestionanswers/create', [
        'as' => 'admin.itrivia.userquestionanswer.create',
        'uses' => 'UserQuestionAnswerController@create',
        'middleware' => 'can:itrivia.userquestionanswers.create'
    ]);
    $router->post('userquestionanswers', [
        'as' => 'admin.itrivia.userquestionanswer.store',
        'uses' => 'UserQuestionAnswerController@store',
        'middleware' => 'can:itrivia.userquestionanswers.create'
    ]);
    $router->get('userquestionanswers/{userquestionanswer}/edit', [
        'as' => 'admin.itrivia.userquestionanswer.edit',
        'uses' => 'UserQuestionAnswerController@edit',
        'middleware' => 'can:itrivia.userquestionanswers.edit'
    ]);
    $router->put('userquestionanswers/{userquestionanswer}', [
        'as' => 'admin.itrivia.userquestionanswer.update',
        'uses' => 'UserQuestionAnswerController@update',
        'middleware' => 'can:itrivia.userquestionanswers.edit'
    ]);
    $router->delete('userquestionanswers/{userquestionanswer}', [
        'as' => 'admin.itrivia.userquestionanswer.destroy',
        'uses' => 'UserQuestionAnswerController@destroy',
        'middleware' => 'can:itrivia.userquestionanswers.destroy'
    ]);
    $router->bind('usertrivia', function ($id) {
        return app('Modules\Itrivia\Repositories\UserTriviaRepository')->find($id);
    });
    $router->get('usertrivias', [
        'as' => 'admin.itrivia.usertrivia.index',
        'uses' => 'UserTriviaController@index',
        'middleware' => 'can:itrivia.usertrivias.index'
    ]);
    $router->get('usertrivias/create', [
        'as' => 'admin.itrivia.usertrivia.create',
        'uses' => 'UserTriviaController@create',
        'middleware' => 'can:itrivia.usertrivias.create'
    ]);
    $router->post('usertrivias', [
        'as' => 'admin.itrivia.usertrivia.store',
        'uses' => 'UserTriviaController@store',
        'middleware' => 'can:itrivia.usertrivias.create'
    ]);
    $router->get('usertrivias/{usertrivia}/edit', [
        'as' => 'admin.itrivia.usertrivia.edit',
        'uses' => 'UserTriviaController@edit',
        'middleware' => 'can:itrivia.usertrivias.edit'
    ]);
    $router->put('usertrivias/{usertrivia}', [
        'as' => 'admin.itrivia.usertrivia.update',
        'uses' => 'UserTriviaController@update',
        'middleware' => 'can:itrivia.usertrivias.edit'
    ]);
    $router->delete('usertrivias/{usertrivia}', [
        'as' => 'admin.itrivia.usertrivia.destroy',
        'uses' => 'UserTriviaController@destroy',
        'middleware' => 'can:itrivia.usertrivias.destroy'
    ]);
    $router->bind('rangepoint', function ($id) {
        return app('Modules\Itrivia\Repositories\RangePointRepository')->find($id);
    });
    $router->get('rangepoints', [
        'as' => 'admin.itrivia.rangepoint.index',
        'uses' => 'RangePointController@index',
        'middleware' => 'can:itrivia.rangepoints.index'
    ]);
    $router->get('rangepoints/create', [
        'as' => 'admin.itrivia.rangepoint.create',
        'uses' => 'RangePointController@create',
        'middleware' => 'can:itrivia.rangepoints.create'
    ]);
    $router->post('rangepoints', [
        'as' => 'admin.itrivia.rangepoint.store',
        'uses' => 'RangePointController@store',
        'middleware' => 'can:itrivia.rangepoints.create'
    ]);
    $router->get('rangepoints/{rangepoint}/edit', [
        'as' => 'admin.itrivia.rangepoint.edit',
        'uses' => 'RangePointController@edit',
        'middleware' => 'can:itrivia.rangepoints.edit'
    ]);
    $router->put('rangepoints/{rangepoint}', [
        'as' => 'admin.itrivia.rangepoint.update',
        'uses' => 'RangePointController@update',
        'middleware' => 'can:itrivia.rangepoints.edit'
    ]);
    $router->delete('rangepoints/{rangepoint}', [
        'as' => 'admin.itrivia.rangepoint.destroy',
        'uses' => 'RangePointController@destroy',
        'middleware' => 'can:itrivia.rangepoints.destroy'
    ]);
// append






});

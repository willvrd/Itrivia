<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/itrivia/v1'], function (Router $router) {

  //======  TRIVIAS
  require('ApiRoutes/triviaRoutes.php');

  //======  QUESTIONS
  require('ApiRoutes/questionRoutes.php');

  //======  ANSWER
  require('ApiRoutes/answerRoutes.php');

  //======  USER QUESTION ANSWER
  require('ApiRoutes/userQuestionAnswerRoutes.php');

  //======  USERS TRIVIAS
  require('ApiRoutes/userTriviaRoutes.php');

  //======  RANGE POINTS
  require('ApiRoutes/rangePointRoutes.php');

});

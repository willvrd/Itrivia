<?php

namespace Modules\Itrivia\Events\Handlers;


class CheckQuestionsAnswers
{
   
    private $userQARepository;
    private $setting;
    private $pointRepository;

    public function __construct()
    {
        $this->userQARepository = app('Modules\Itrivia\Repositories\UserQuestionAnswerRepository');
        $this->setting = app('Modules\Setting\Contracts\Setting');
        $this->pointRepository =  app('Modules\Iredeems\Repositories\PointRepository');
    }

    public function handle($event)
    {
        $userTrivia = $event->userTrivia;
        $data = $event->data;

        // Data to return
        $inforResult = null;

        // Settings Iredeems
        $checkTrivia =  $this->setting->get('iredeems::points-per-finished-trivia-checkbox');

        // Points Actives
        if($checkTrivia){

            $qOk = 0;

            // Get questions for the Trivia
            $questions = $userTrivia->trivia->questions;

            foreach ($questions as $key => $question) {
                //echo "Pregunta: ".$question->title."<br>";
                $answers = $question->answers;
                // Get Correct Answer
                $answerId = null;
                foreach($answers as $answer){
                    if($answer->correct){
                        //echo "*Respuesta correcta: ".$answer->id."<br>";
                        $answerId = $answer->id;
                        break;
                    }    
                }

                // Get answer from User
                $attributes = array(
                    "user_id" => $userTrivia->user_id,
                    "question_id" => $question->id
                );
                $result = $this->userQARepository->findByAttributes($attributes);
                //echo "*Respuesta Usuario: ".$result->answer_id."<br>";
                // Check if the answer was correct
                if($result->answer_id==$answerId){
                    //echo "***Respuesta Acertada ***<br>";
                    $qOk++;
                }
            }// End Foreach

            // Results
            $totalQuestions = count($questions);
            $porcentComplete = $qOk * 100 /  $totalQuestions;
            //echo "<br> Total de Preguntas: {$totalQuestions} <br>";
            //echo "Acertadas:{$qOk} <br>";
            //echo "Porcentaje Completado: {$porcentComplete} % <br><br>";

            // Range Points
            $sumPoints = 0;
            $rangePoints = $userTrivia->trivia->rangePoints;

            // Trivia has Range Points
            if(count($rangePoints)>0){
                $sorted = $rangePoints->sortByDesc('value');

                foreach ($sorted as $key => $range) {
                    //echo "Rango de puntos para:".$range->value." % Completado - Puntos: ".$range->points."<br>";
                    if($range->value==$porcentComplete){
                        $sumPoints = $range->points;
                        break;
                    }else{
                        // If porcentaje complete isn't exactly but is major than other
                        if($porcentComplete>=$range->value){
                            $sumPoints = $range->points;
                            break; 
                        }
                    }  
                }
                
            }else{

                //Trivia Doesn't have Range points, Take setting
                $pointsTrivia = $this->setting->get('iredeems::points-per-finished-trivia');
                if($porcentComplete==100)
                    $sumPoints = (int)$pointsTrivia;

            }
            //echo "Puntos para el Usuario: {$sumPoints} <br>"; 
            
            // Save Points
            $class=\Modules\Itrivia\Entities\Trivia::class;
            $data = array(
                "user_id"=> (int)$userTrivia->user_id,
                "pointable_id" => (int)$userTrivia->trivia_id,
                "pointable_type" => $class,
                "points" => (int)$sumPoints,
                "type" => "trivia-completed",
                "description" => trans("iredeems::common.settingsMsg.points-per-trivia")
            );
            $this->pointRepository->create($data);

            $inforResult = array(
                'questionsTotal' => $totalQuestions, 
                'userOkQuestions' => $qOk,
                'questionsPercentCompleted' => $porcentComplete,
                'rangePoints' => count($rangePoints) > 0 ? 1 : 0, // If Trivia Has range points
                'pointsWinner' => $sumPoints
            );

            return $inforResult;

        }

    }// If handle

}
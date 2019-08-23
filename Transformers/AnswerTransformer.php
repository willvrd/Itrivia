<?php

namespace Modules\Itrivia\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class AnswerTransformer extends Resource
{
  public function toArray($request)
  {

    $item =  [
      'id' => $this->when($this->id,$this->id),
      'title' => $this->when($this->title,$this->title),
      'correct' => $this->when(\Auth::check() && \Auth::user()->hasAccess(['itrivia.answers.create']) && $this->correct, $this->correct),
      'question_id' => $this->when($this->question_id,$this->question_id),
      'question' => new QuestionTransformer($this->whenLoaded('question')),
      'userQuestionAnswers' => UserQuestionAnswerTransformer::collection($this->whenLoaded('userQuestionAnswers')),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at)
    ];
  
    return $item;
    
  }
}

<?php

namespace Modules\Itrivia\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class UserQuestionAnswerTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->when($this->id,$this->id),
      'user_id' => $this->when($this->user_id,$this->user_id),
      'question_id' => $this->when($this->question_id,$this->question_id),
      'question' => new QuestionTransformer($this->whenLoaded('question')),
      'answer_id' => $this->when($this->answer_id,$this->answer_id),
      'answer' => new AnswerTransformer($this->whenLoaded('answer')),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at)
    ];
    
    return $item;
    
  }
}

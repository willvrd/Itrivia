<?php

namespace Modules\Itrivia\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class QuestionTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->when($this->id,$this->id),
      'title' => $this->when($this->title,$this->title),
      'multiple' => $this->when($this->multiple,$this->multiple),
      'points' => $this->when($this->points,$this->points),
      'trivia_id' => $this->when($this->trivia_id,$this->trivia_id),
      'trivia' => new TriviaTransformer($this->whenLoaded('trivia')),
      'answers' => AnswerTransformer::collection($this->whenLoaded('answers')),
      'userQuestionAnswers' => UserQuestionAnswerTransformer::collection($this->whenLoaded('userQuestionAnswers')),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at)
    ];

     // TRANSLATIONS
     $filter = json_decode($request->filter);
     // Return data with available translations
     if (isset($filter->allTranslations) && $filter->allTranslations) {
       // Get langs avaliables
       $languages = \LaravelLocalization::getSupportedLocales();
       foreach ($languages as $lang => $value) {
         if ($this->hasTranslation($lang)) {
           $item[$lang]['title'] = $this->hasTranslation($lang) ?
             $this->translate("$lang")['title'] : '';
         }
       }
     }
    
    return $item;
    
  }
}

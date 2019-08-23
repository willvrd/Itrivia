<?php

namespace Modules\Itrivia\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class UserTriviaTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->when($this->id,$this->id),
      'user_id' => $this->when($this->user_id,$this->user_id),
      'trivia_id' => $this->when($this->trivia_id,$this->trivia_id),
      'trivia' => new TriviaTransformer($this->whenLoaded('trivia')),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at)
    ];
    
    return $item;
    
  }
}

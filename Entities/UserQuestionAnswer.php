<?php

namespace Modules\Itrivia\Entities;

use Illuminate\Database\Eloquent\Model;

class UserQuestionAnswer extends Model
{
    
    protected $table = 'itrivia__user_question_answers';
    protected $fillable = [
        'user_id',
        'question_id',
        'answer_id'
    ];

    public function user()
    {
      $driver = config('asgard.user.config.driver');
      return $this->belongsTo('Modules\\User\\Entities\\{$driver}\\User');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }


}

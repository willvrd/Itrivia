<?php

namespace Modules\Itrivia\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use Translatable;

    protected $table = 'itrivia__answers';
    public $translatedAttributes = [
        'title'
    ];
    protected $fillable = [
        'question_id',
        'correct'
    ];

    /*
    protected $casts = [
        'correct' => 'boolean',
    ];
    */

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function userQuestionAnswers()
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }


}

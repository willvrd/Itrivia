<?php

namespace Modules\Itrivia\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use Translatable;

    protected $table = 'itrivia__questions';
    public $translatedAttributes = [
        'title'
    ];
    protected $fillable = [
        'multiple',
        'points',
        'trivia_id'
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function trivia()
    {
        return $this->belongsTo(Trivia::class);
    }

    public function userQuestionAnswers()
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }

    /**
     * Magic Method modification to allow dynamic relations to other entities.
     * @var $value
     * @var $destination_path
     * @return string
     */
    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.itrivia.config.relations.questions', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

}

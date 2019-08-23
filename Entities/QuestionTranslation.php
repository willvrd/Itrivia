<?php

namespace Modules\Itrivia\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title'
    ];
    protected $table = 'itrivia__question_translations';
}

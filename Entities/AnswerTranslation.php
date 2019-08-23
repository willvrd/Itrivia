<?php

namespace Modules\Itrivia\Entities;

use Illuminate\Database\Eloquent\Model;

class AnswerTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title'
    ];
    protected $table = 'itrivia__answer_translations';
}

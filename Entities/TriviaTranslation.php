<?php

namespace Modules\Itrivia\Entities;

use Illuminate\Database\Eloquent\Model;

class TriviaTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title',
        'description'
    ];
    protected $table = 'itrivia__trivia_translations';
}

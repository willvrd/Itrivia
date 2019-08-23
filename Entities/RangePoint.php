<?php

namespace Modules\Itrivia\Entities;

use Illuminate\Database\Eloquent\Model;

class RangePoint extends Model
{
    
    protected $table = 'itrivia__rangepoints';
    protected $fillable = [
        'value',
        'points',
        'trivia_id'
    ];

    public function trivia()
    {
        return $this->belongsTo(Trivia::class);
    }


}

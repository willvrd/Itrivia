<?php

namespace Modules\Itrivia\Entities;

use Illuminate\Database\Eloquent\Model;

class UserTrivia extends Model
{
    

    protected $table = 'itrivia__user_trivias';
    protected $fillable = [
        'user_id',
        'trivia_id'
    ];

    public function user()
    {
      $driver = config('asgard.user.config.driver');
      return $this->belongsTo('Modules\\User\\Entities\\{$driver}\\User');
    }

    public function trivia()
    {
        return $this->belongsTo(Trivia::class);
    }


}

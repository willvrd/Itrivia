<?php

namespace Modules\Itrivia\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface TriviaRepository extends BaseRepository
{

    public function getItemsBy($params);
  
    public function getItem($criteria, $params);

    
}

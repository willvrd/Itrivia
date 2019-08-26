<?php

namespace Modules\Itrivia\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface AnswerRepository extends BaseRepository
{

    public function getItemsBy($params);
  
    public function getItem($criteria, $params);

    
}

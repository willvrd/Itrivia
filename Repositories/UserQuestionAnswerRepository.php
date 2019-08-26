<?php

namespace Modules\Itrivia\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface UserQuestionAnswerRepository extends BaseRepository
{

    public function getItemsBy($params);
  
    public function getItem($criteria, $params);

    public function create($data);
    
}

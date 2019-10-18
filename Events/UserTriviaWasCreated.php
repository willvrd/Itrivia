<?php

namespace Modules\Itrivia\Events;

use Modules\Itrivia\Entities\UserTrivia;

class UserTriviaWasCreated
{
    public $userTrivia;
    public $data;

    public function __construct(UserTrivia $userTrivia, array $data)
    {
        $this->userTrivia = $userTrivia;
        $this->data = $data;
    }

}
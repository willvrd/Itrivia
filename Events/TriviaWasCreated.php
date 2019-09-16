<?php

namespace Modules\Itrivia\Events;

use Modules\Itrivia\Entities\Trivia;
use Modules\Media\Contracts\StoringMedia;


class TriviaWasCreated implements StoringMedia
{
    private $trivia;
    private $data;

    public function __construct($trivia, $data)
    {
        $this->trivia = $trivia;
        $this->data = $data;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->trivia;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
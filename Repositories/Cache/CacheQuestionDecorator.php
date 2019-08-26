<?php

namespace Modules\Itrivia\Repositories\Cache;

use Modules\Itrivia\Repositories\QuestionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheQuestionDecorator extends BaseCacheDecorator implements QuestionRepository
{
    public function __construct(QuestionRepository $question)
    {
        parent::__construct();
        $this->entityName = 'itrivia.questions';
        $this->repository = $question;
    }

       /**
     * List or resources
     *
     * @return collection
     */
    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
        return $this->repository->getItemsBy($params);
        });
    }
    
    /**
     * find a resource by id or slug
     *
     * @return object
     */
    public function getItem($criteria, $params)
    {
        return $this->remember(function () use ($criteria, $params) {
        return $this->repository->getItem($criteria, $params);
        });
    }


}

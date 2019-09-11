<?php

namespace Modules\Itrivia\Repositories\Cache;

use Modules\Itrivia\Repositories\UserQuestionAnswerRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheUserQuestionAnswerDecorator extends BaseCacheDecorator implements UserQuestionAnswerRepository
{
    public function __construct(UserQuestionAnswerRepository $userquestionanswer)
    {
        parent::__construct();
        $this->entityName = 'itrivia.userquestionanswers';
        $this->repository = $userquestionanswer;
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


        /**
     * create a resource
     *
     * @return mixed
     */
    public function create($data)
    {
        $this->clearCache();
        
        return $this->repository->create($data);
    }
    

    
}

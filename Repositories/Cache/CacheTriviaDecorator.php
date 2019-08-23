<?php

namespace Modules\Itrivia\Repositories\Cache;

use Modules\Itrivia\Repositories\TriviaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTriviaDecorator extends BaseCacheDecorator implements TriviaRepository
{
    public function __construct(TriviaRepository $trivia)
    {
        parent::__construct();
        $this->entityName = 'itrivia.trivias';
        $this->repository = $trivia;
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
   * update a resource
   *
   * @return mixed
   */
  public function updateBy($criteria, $data, $params)
  {
    $this->clearCache();
    return $this->repository->updateBy($criteria, $data, $params);
  }
  
  /**
   * destroy a resource
   *
   * @return mixed
   */
  public function deleteBy($criteria, $params)
  {
    $this->clearCache();
    return $this->repository->deleteBy($criteria, $params);
  }
  
}

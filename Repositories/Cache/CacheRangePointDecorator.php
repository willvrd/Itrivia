<?php

namespace Modules\Itrivia\Repositories\Cache;

use Modules\Itrivia\Repositories\RangePointRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRangePointDecorator extends BaseCacheDecorator implements RangePointRepository
{
    public function __construct(RangePointRepository $rangepoint)
    {
        parent::__construct();
        $this->entityName = 'itrivia.rangepoints';
        $this->repository = $rangepoint;
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

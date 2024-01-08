<?php

namespace Modules\Slider\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Slider\Repositories\SliderRepository;

class CacheSliderDecorator extends BaseCacheDecorator implements SliderRepository
{
    /**
     * @var SliderRepository
     */
    protected $repository;

    public function __construct(SliderRepository $slider)
    {
        parent::__construct();
        $this->entityName = 'slider.sliders';
        $this->repository = $slider;
    }

    /**
     * Get all online sliders
     * @return object
     */
    public function allOnline()
    {
        $key = "{$this->locale}.{$this->entityName}.allOnline";
        return $this->remember(function () {
            return $this->repository->allOnline();
        }, $key);
    }

    public function countAll()
    {
        $key = "{$this->locale}.{$this->entityName}.countAll";
        return $this->remember(function () {
            return $this->repository->countAll();
        }, $key);
    }
    
    public function findBySystemName($systemName)
    {
        $key = "{$this->locale}.{$this->entityName}.findBySystemName.{$systemName}";
        return $this->remember(function () use ($systemName) {
            return $this->repository->findBySystemName($systemName);
        }, $key);
    }
}

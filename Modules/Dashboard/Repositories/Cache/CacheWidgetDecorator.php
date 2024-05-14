<?php

namespace Modules\Dashboard\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Dashboard\Repositories\WidgetRepository;

class CacheWidgetDecorator extends BaseCacheDecorator implements WidgetRepository
{
    public function __construct(WidgetRepository $widgets)
    {
        parent::__construct();
        $this->entityName = 'dashboard.widgets';
        $this->repository = $widgets;
    }

    /**
     * Find the saved state of widgets for the given user id
     * @param int $userId
     * @return string
     */
    public function findForUser($userId)
    {
        $key = "{$this->locale}.{$this->entityName}.findForUser.{$userId}";
        return $this->remember(function () use ($userId) {
            return $this->repository->findForUser($userId);
        }, $key);
    }

    /**
     * Update or create the given widgets for given user
     * @param array $widgets
     * @param $userId
     * @return mixed|void
     */
    public function updateOrCreateForUser($widgets, $userId)
    {
        $key = "{$this->locale}.{$this->entityName}.updateOrCreateForUser.{$userId}";
        return $this->remember(function () use ($widgets, $userId) {
            return $this->repository->updateOrCreateForUser($widgets, $userId);
        }, $key);
    }
}

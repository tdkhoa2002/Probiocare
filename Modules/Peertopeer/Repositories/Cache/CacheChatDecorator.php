<?php

namespace Modules\Peertopeer\Repositories\Cache;

use Modules\Peertopeer\Repositories\ChatRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheChatDecorator extends BaseCacheDecorator implements ChatRepository
{
    public function __construct(ChatRepository $chat)
    {
        parent::__construct();
        $this->entityName = 'peertopeer.chats';
        $this->repository = $chat;
    }
}

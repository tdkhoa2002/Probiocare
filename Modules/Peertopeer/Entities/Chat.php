<?php

namespace Modules\Peertopeer\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class Chat extends Model
{
    use MediaRelation;
    protected $table = 'peertopeer__chats';
    protected $fillable = [
        'order_id',
        'customer_id',
        'customer_avatar',
        'message',
        'send_date'
    ];

    public function attachChat(){
        return $this->filesByZone('ATTACH_CHAT')->first();
    }
}

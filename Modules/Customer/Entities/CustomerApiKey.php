<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerApiKey extends Model
{
    use HasFactory;

    protected $table = "customer__customerapikeys";

    protected $fillable = [
        'title', 'token', 'customer_id', 'expired_at', 'call_count', 'last_called_at',
    ];

    protected $dates = ['expired_at', 'last_called_at'];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}

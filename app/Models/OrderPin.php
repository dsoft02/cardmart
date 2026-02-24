<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPin extends Model
{

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function pin()
    {
        return $this->belongsTo(Pin::class);
    }
}

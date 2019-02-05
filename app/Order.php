<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'double';
    protected $primaryKey = 'order_id';
    protected $table = 'orders';
}

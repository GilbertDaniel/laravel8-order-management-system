<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'orders';

    protected $fillable = ['order_no', 'final_total'];

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}

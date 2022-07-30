<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price','sku', 'category_id', 'description'];

    public function category()
    {
        return $this->belongsTo(ItemCategory::class);
    }
}

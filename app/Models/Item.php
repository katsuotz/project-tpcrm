<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'unit',
        'warehouse_id',
        'category_id',
        'image',
    ];

    public function category () {
        return $this->belongsTo(Category::class);
    }

    public function getStockAttribute($stock)
    {
        return $this->attributes['stock'] = sprintf('%s', number_format($stock, 2)) + 0;
    }
}

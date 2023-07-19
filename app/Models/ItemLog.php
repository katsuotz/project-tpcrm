<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'qty',
        'price',
        'type',
        'image',
    ];
}

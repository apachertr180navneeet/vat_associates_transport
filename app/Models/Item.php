<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;

    use SoftDeletes;


    // Table name (optional, if different from plural model name)
    protected $table = 'items';

    // Mass assignable fields
    protected $fillable = [
        'firm_id',
        'name',
        'skucode',
        'measurment',
        'group',
        'methiod',
        'open_stock',
        'price',
        'description',
        'image',
        'status'
    ];

    // Enable date casting for timestamps and soft deletes
    protected $dates = ['deleted_at'];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuiltyItem extends Model
{
    use HasFactory;

    use SoftDeletes;

    // Table name (optional, if different from plural model name)
    protected $table = 'builty_item';

    // Mass assignable fields
    protected $fillable = [
        'builty_item_id',
        'item',
        'freight_charge',
        'surcharge',
        'cover',
        'h',
        'insurance',
        'heading',
        'cps',
        'total'
    ];

    // Enable date casting for timestamps and soft deletes
    protected $dates = ['deleted_at'];
}

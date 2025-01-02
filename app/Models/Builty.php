<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Builty extends Model
{
    use HasFactory;

    use SoftDeletes;

    // Table name (optional, if different from plural model name)
    protected $table = 'builty';

    // Mass assignable fields
    protected $fillable = [
        'firm_id',
        'date',
        'type',
        'branch',
        'grno',
        'consigner',
        'conignee',
        'from_city',
        'to_city',
        'good_location',
        'no_of_package',
        'total_price',
        'status'
    ];

    // Enable date casting for timestamps and soft deletes
    protected $dates = ['deleted_at'];
}

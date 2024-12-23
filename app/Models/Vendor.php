<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;

    use SoftDeletes;


    // Table name (optional, if different from plural model name)
    protected $table = 'vendors';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'contact',
        'email',
        'gstn',
        'type',
        'status',
        'firm_id'
    ];

    // Enable date casting for timestamps and soft deletes
    protected $dates = ['deleted_at'];
}

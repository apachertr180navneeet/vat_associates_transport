<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;

    use SoftDeletes;


    // Table name (optional, if different from plural model name)
    protected $table = 'departments';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'type',
        'level',
        'firm_id',
        'descrption',
        'status'
    ];

    // Enable date casting for timestamps and soft deletes
    protected $dates = ['deleted_at'];
}

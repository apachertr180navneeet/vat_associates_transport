<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FirmType extends Model
{
    use HasFactory,SoftDeletes;

    // Allow mass assignment for 'name','status'
    protected $fillable = ['name','status'];


    // Optional: Customize the date format
    protected $dates = ['deleted_at'];
}

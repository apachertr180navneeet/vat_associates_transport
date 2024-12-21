<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firm extends Model
{
    use HasFactory,SoftDeletes;

    // Allow mass assignment for 'firm_type', 'firm_name', and additional fields
    protected $fillable = [
        'firm_type', // Type of the firm
        'firm_name', // Name of the firm
        'email',     // Unique email address
        'phone',     // Unique phone number
        'location',  // Location of the firm
        'address',   // Address of the firm
        'city',      // City where the firm is located
        'state',     // State where the firm is located
        'zipcode',   // Zip code of the firm's location
        'status'     // Status of the firm (active/inactive)
    ];

    // Optional: Customize the date format
    protected $dates = ['deleted_at'];

    public function firmType() {
        return $this->belongsTo(FirmType::class, 'firm_type'); // Assuming 'firm_type_id' is the foreign key in the firms table
    }
}

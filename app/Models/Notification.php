<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    
    protected $fillable = [];
    
    protected $hidden = [
        "created_at"
    ];
    protected $casts = [
        'data' => 'array',
    ];
}

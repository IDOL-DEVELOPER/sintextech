<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionMap extends Model
{
    use HasFactory;

    protected $table = 'permission_map';

    protected $fillable = [];

     protected $hidden = [
        "created_at"
    ];
}

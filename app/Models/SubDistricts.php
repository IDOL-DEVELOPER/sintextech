<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDistricts extends Model
{
    use HasFactory;

    protected $table = 'sub_districts';

    protected $fillable = [
        "name",
        "did",
        "status"
    ];

    protected $hidden = [
        "created_at"
    ];
    public function district()
    {
        return $this->belongsTo(Districts::class, 'did');
    }
}

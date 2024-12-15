<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = [
        "name",
        "sid",
        "status"
    ];

    protected $hidden = [
        "created_at"
    ];
    public function subdistricts()
    {
        return $this->hasMany(SubDistricts::class, 'did');
    }
    public function state()
    {
        return $this->belongsTo(States::class, 'sid');
    }
}

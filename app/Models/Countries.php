<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = [
        "name",
        "status"
    ];

    protected $hidden = [
        "created_at"
    ];
    public function states()
    {
        return $this->hasMany(States::class, 'cid');
    }
}

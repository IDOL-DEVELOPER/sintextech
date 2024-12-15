<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;

    protected $table = 'states';

    protected $fillable = [
        "name",
        "cid",
        "status"
    ];

    protected $hidden = [
        "created_at"
    ];
    public function districts()
    {
        return $this->hasMany(Districts::class, 'sid');
    }
    public function country()
    {
        return $this->belongsTo(Countries::class, 'cid');
    }
}

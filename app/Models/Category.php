<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'name',
        'status'
    ];

    protected $hidden = [
        "created_at"
    ];
    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }
}

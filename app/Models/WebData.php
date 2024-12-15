<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebData extends Model
{
    use HasFactory;

    protected $table = 'website_data';

    protected $fillable = [
        'website_name',
        'websitelogo',
        'websitesmallogo',
        'address',
        'city',
        'state',
        'country',
        'zip',
    ];

    protected $hidden = [
        "created_at"
    ];

    public function logo()
    {
        return $this->belongsTo(Upload::class, 'websitelogo');
    }
    public function favicon()
    {
        return $this->belongsTo(Upload::class, 'websitesmallogo');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;
    protected $table = "submenu";
    public function menu()
    {
        return $this->belongsTo(Menus::class, 'menu_id');
    }
    public function permissions()
    {
        return $this->hasMany(Permissions::class, 'subid');
    }

}

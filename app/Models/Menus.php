<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;

    protected $table = "menus";

    public function submenu()
    {
        return $this->hasMany(SubMenu::class, 'menu_id');
    }
    public function permissions()
    {
        return $this->hasMany(Permissions::class,"mid");
    }
}

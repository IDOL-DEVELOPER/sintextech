<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;

    protected $table = "permissions";
    public function menus()
    {
        return $this->belongsTo(Menus::class, "mid");
    }
    public function submenu()
    {
        return $this->belongsTo(SubMenu::class, "subid");
    }
}

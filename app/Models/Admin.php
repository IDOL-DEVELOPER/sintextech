<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Trait\Permission;
class Admin extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use Permission;
    protected $primaryKey = 'id';
    protected $guard = "admin";
    protected $table = "admins";

    protected $fillable = [
        "email",
        "ids",
        "name",
        "password",
        "remember_token",
        'address',
        'phone',
        "status",
        "role",
    ];
    protected $hidden = [
        "remember_token",
        "password",
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function instance()
    {
        return "admin";
    }


    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role');
    }
}

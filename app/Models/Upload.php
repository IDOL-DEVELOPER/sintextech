<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Relation;


class Upload extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'upload';

    protected $fillable = [
        'original_name',
        'file_name',
        'user_id',
        'user_instance',
        'file_size',
        'extension',
        'type',
        'external_link'
    ];

    protected $hidden = [
        "created_at"
    ];
    protected static function boot()
    {
        parent::boot();

        Relation::morphMap([
            'admin' => Admin::class,
        ]);
    }

    public function createdBy()
    {
        $instance = $this->instance_created;
        $userId = $this->auth_id;

        if ($instance && $userId) {
            $modelClass = Relation::getMorphedModel($instance);
            if ($modelClass) {
                if ($modelClass) {
                    $user = $modelClass::findOrFail($userId);
                    $userName = $user->first_name ?? $user->name;
                    return $userName;
                }
            }
        }

        return 'N/A';
    }

}

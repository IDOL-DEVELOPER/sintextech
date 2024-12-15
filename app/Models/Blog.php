<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;


class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $fillable = [
        'cate_id',
        'title',
        'content',
        'slug',
        'brief',
        'views',
        'likes',
        'tags',
        'image_id',
        'auth_id',
        'instance_created',
        'meta_key',
        'meta_title',
        'meta_desc',
        'status',
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

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function upload()
    {
        return $this->belongsTo(Upload::class, 'image_id');
    }
    public function comments()
    {
        return $this->hasMany(Blog::class, 'blog_id');
    }
}

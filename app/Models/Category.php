<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ["title", "slug"];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    // this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();

        static::deleting(function($category) {
            $ids = $category->posts()->pluck("id")->toArray();

            // set category id to default (uncategorize)
            Post::whereIn('id', $ids)->update(['category_id' => 1]);
        });
    }
}

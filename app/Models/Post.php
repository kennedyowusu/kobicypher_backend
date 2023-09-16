<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id',
    ];

    public function category(){
        //  A post can only have one category, but a category can have many posts
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        //  A post can have many tags, and a tag can have many posts
        return $this->belongsToMany(Tag::class);
    }
}

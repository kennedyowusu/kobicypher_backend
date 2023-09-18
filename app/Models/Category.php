<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=['name','description'];

    public function posts(){
        //  A category can have many posts, but a post can only have one category
        return $this->hasMany(Post::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'category_id');
    }

}

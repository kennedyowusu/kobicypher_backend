<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function posts(){
        //  A tag can have many posts, and a post can have many tags
        return $this->belongsToMany(Post::class);
    }

}

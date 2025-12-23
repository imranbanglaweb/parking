<?php

namespace App\Models;


class Tag extends BaseModel
{
    public $timestamps = false;


    protected $table = "tags";

    /**
     * The tags that belong to the post.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}

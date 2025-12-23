<?php

namespace App\Models;

use App\Facades\Voyager;
use App\Voyager\Traits\Resizable;
use App\Voyager\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;

class Post extends BaseModel
{
    use Translatable,
        Resizable;

    protected $translatable = ['title', 'seo_title', 'excerpt', 'body', 'slug', 'meta_description', 'meta_keywords'];

    const PUBLISHED = 'PUBLISHED';

    protected $guarded = [];

    public function save(array $options = [])
    {
        /** If no author has been assigned, assign the current user's id as the author of the post */
        if (!$this->author_id && app('VoyagerAuth')->user()) {
            $this->author_id = app('VoyagerAuth')->user()->getKey();
        }

        parent::save();
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'posts_tags', 'post_id', 'tag_id');
    }

    public function authorId()
    {
        return $this->belongsTo(Voyager::modelClass('User'), 'author_id', 'id');
    }

    /**
     * Scope a query to only published scopes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', static::PUBLISHED);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Voyager::modelClass('Category'));
    }
}

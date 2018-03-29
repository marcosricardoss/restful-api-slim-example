<?php

namespace Marcosricardoss\Restful\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Post extends Eloquent {    

    protected $visible = ['id', 'title', 'content', 'created_at', 'updated_at', 'category', 'keywords', 'created_by'];
    protected $fillable = ['title', 'content'];
    
    /**
     * Get the creator of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function created_by() {
        return $this->belongsTo('Marcosricardoss\Restful\Model\User', 'created_by');
    }

     /**
     * Get the category the post belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo('Marcosricardoss\Restful\Model\Category');
    }

    /**
     * Get the keywords associated with the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function keywords() {
        return $this->belongsToMany('Marcosricardoss\Restful\Model\Keyword', 'post_keywords');
    }

    /**
     * Scope a query to include relations.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRelations($query) {
        return $query->with('category', 'keywords', 'created_by');
    }    
}
<?php

namespace Marcosricardoss\Restful\Model;

use Illuminate\Database\Capsule\Manager;
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
    
    /**
     * Scope a query to search by keyword name.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByKeywordName($query, $keywordName) {
        return $query->withRelations()
                     ->joinKeywordsTableLikeNameColumn($keywordName);
    }

    /**
     * Scope query to join keyowords table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJoinKeywordsTableLikeNameColumn($query, $name) {
        return $query
                ->join('post_keywords', 'post_keywords.post_id', '=', 'posts.id')
                ->join('keywords',
                            function ($join) use ($name) {
                                $join->on('post_keywords.keyword_id', '=', 'keywords.id');
                                $join->where('keywords.name', 'like', "%$name%");
                            }
                        )
                    ->select(Manager::raw('posts.*'));
    }

}
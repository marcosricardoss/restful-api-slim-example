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
     * Scope a query to search by post title.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByTitle($query, $postTitle){
        return $query->withRelations()->where('title', 'like', "%$postTitle%");        
    }

     /**
     * Scope a query to search by category name.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByCategoryName($query, $categoryName){
        return $query->withRelations()
                     ->joinTableLikeNameColumn('categories', $categoryName, 'category_id');
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
     * Scope a query to search by the creator's name.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByCreatorName($query, $creatorName) {
        return $query->withRelations()
                     ->joinTableLikeNameColumn('users', $creatorName, 'created_by', 'username');
    }

    /**
     * Scope a query to join search table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeJoinTableLikeNameColumn($query, $tableName, $name, $idFieldOnPost = 'id', $nameColumn = 'name') {
        return $query->join($tableName,
                            function ($join) use ($tableName, $name, $nameColumn, $idFieldOnPost) {
                                $join->on("posts.$idFieldOnPost", '=', "$tableName.id");
                                $join->where("$tableName.$nameColumn", 'like', "%$name%");
                            }
                        )
                    ->select(Manager::raw('posts.*'));
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
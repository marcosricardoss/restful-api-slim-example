<?php

namespace Marcosricardoss\Restful\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Post extends Eloquent {    
    
    /**
     * Get the creator of the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function created_by() {
        return $this->belongsTo('Marcosricardoss\Restful\Model\User', 'created_by');
    }
}
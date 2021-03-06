<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = [
        'published_at'
    ];
    
    protected $fillable = [
        'title', 'description', 'content', 'image', 'published_at', 'user_id', 'category_id'
    ];

    /**
     * delete post image from storage
     * @return void
     */

    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags() 
    {
        return $this->belongsToMany(Tag::class);
        // alternatively
        // return $this->belongsToMany('App\Tag');
    }

    /**
     * check if post has tag(s)
     * @return boot
     */
    public function hasTag ($tagId)
    {
        return in_array( $tagId, $this->tags->pluck('id')->toArray() );
    }


    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }


    public function scopeSearched($query)
    {
        $search = request()->query('search');

        if(!$search) {
            return $query->published();
        }

        return $query->published()->where('title', 'LIKE', "%{$search}%");
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Overtrue\LaravelLike\Traits\Likeable;

class Post extends Model
{
    use HasFactory, HasUlids, Likeable, Favoriteable;

    // protected $fillable = ['hide_like_view', 'description', 'allow_commenting', 'type', 'location', 'user_id'];
    protected $guarded = [];
    protected $casts = ['hide_like_view' => 'boolean', 'allow_commenting' => 'boolean'];
    protected $with = ['likers'];

    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function media(): MorphMany {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable')->with('replies');
    }
}

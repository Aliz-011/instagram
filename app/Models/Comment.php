<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Overtrue\LaravelLike\Traits\Likeable;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Likeable;

    protected $guarded = [];

    public function commentable() {
        return $this->morphTo();
    }

    public function parent(){
        return $this->belongsTo(Self::class, 'parent_id');
    }

    public function replies(){
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

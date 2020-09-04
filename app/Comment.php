<?php

namespace App;

use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Uuids;
    protected $guarded = [];
    protected $with = ['user', 'votes'];
    protected $appends = ['RepliesCount'];

    public function user() {
     
        return $this->belongsTo(User::class);
    }

    public function video() {
     
        return $this->belongsTo(Video::class);
    }

    public function replies() {
        
        return $this->hasMany(Comment::class, 'comment_id')->whereNotNull('comment_id')->latest();
    }

    public function votes() {
     
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function getRepliesCountAttribute()
    {
        return $this->replies->count();
    }
}

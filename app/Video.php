<?php

namespace App;

use App\Vote;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Uuids;
    protected $guarded = [];

    public function channel() {
     
        return $this->belongsTo(Channel::class);
    }

    public function votes() {
     
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function comments() {
        
        return $this->hasMany(Comment::class)->whereNull('comment_id')->latest();
    }

    public function ownerIsCurrentUser() {
     
        return $this->channel->user_id === Auth::id();
    }

}

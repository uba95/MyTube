<?php

namespace App;

use Spatie\MediaLibrary\HasMedia;
use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Channel extends Model implements HasMedia
{
    use Uuids;
    use InteractsWithMedia;

    protected $guarded = [];

    public function user() {
     
        return  $this->belongsTo(User::class);
    }

    public function image() {
       return $this->getFirstMediaUrl('images', 'thumb') ?? null;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(100)->height(100);
    }

    public function ownerIsCurrentUser() {
     
        return $this->user_id === Auth::id();
    }

    public function subscriptions() {
     
        return $this->hasMany(Subscription::class);
    }

    public function videos() {
     
        return $this->hasMany(Video::class);
    }
}

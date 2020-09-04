<?php

namespace App;

use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use Uuids;
    protected $guarded = [];

    public function voteable() {
     
        return $this->morphTo();
    }
}

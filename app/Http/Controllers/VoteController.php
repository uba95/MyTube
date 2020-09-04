<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Video;
use App\Vote;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote($entityId, $type) {

        $entity = $this->getEntity($entityId);
        return Auth::user()->toggleVote($entity, $type);
    }

    public function getEntity($entityId) {
     
        try {

            return Video::find($entityId) ?? Comment::find($entityId);
        } catch (ModelNotFoundException $exception) {

            return $exception->getMessage();

        }
    }

    public function destroy(Vote $vote) {
     
        $vote->delete();
        return response()->json(['deleted']);
    }
}

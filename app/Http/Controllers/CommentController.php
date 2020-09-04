<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Video $video) {
     
        return $video->comments()->paginate(10);
    }

    public function show(Comment $comment) {
     
        return $comment->replies()->paginate(5);
    }

    public function store(Request $request) {
     
        return Auth::user()->comments()->create($request->only('body', 'video_id','comment_id',))->fresh();
    }
}

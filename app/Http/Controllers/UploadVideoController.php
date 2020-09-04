<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Jobs\CreateVideoThumbnailJob;
use App\Jobs\Videos\ConvertForStreamingJob;
use Illuminate\Http\Request;

class UploadVideoController extends Controller
{
    public function index(Channel $channel) {
     
        return view('channels.upload', compact('channel'));
    }

    public function store(Channel $channel) {

        $video = $channel->videos()->create([
            'title' => request()->title,
            'path' => request()->video->store("channels/{$channel->id}"),
        ]);

        CreateVideoThumbnailJob::dispatch($video);
        ConvertForStreamingJob::dispatch($video);
        return $video;
    }
}

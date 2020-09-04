@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <channel-uploads :channel="{{ $channel }}" inline-template>
            <div class="col-md-8">

                <div class="card p-3 d-flex justify-content-between align-items-center" v-if="!selected">
                    <div class="btn btn-danger p-0" onclick="document.getElementById('video-input').click()">
                        <input @change="upload" ref="videos" multiple type="file"
                        name="video" id="video-input" class="d-none">
                        <span><i class="fab fa-youtube fa-5x"></i></span>
                        
                    </div>
                    <p>Upload Video</p>    
                </div>

                <div class="card p-3" v-else>
                    <div class="my-4"  v-for="video in videos">
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped" role="progressbar"aria-valuenow="75" 
                            aria-valuemin="0" aria-valuemax="100" :style="{width: `${ video.percentage || progress[video.name]}%`}">
                                @{{  video.percentage ? video.percentage == 100 ? 'Video Processing Completed' : 'Processing' : 'Uploading' }}
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div v-if="!video.thumbnail" class="d-flex justify-content-center align-items-center bg-dark"
                                style="height: 180px;color:white;font-size: 18px">
                                    Loading Thumbnail ...
                                </div>
                                <img v-else :src="video.thumbnail" alt="" style="width: 100%">
                            </div>

                            <div class="col-md-4">
                                <a v-if="video.percentage && video.percentage == 100" :href="`/videos/${video.id}`" target="_blank">@{{ video.title }}</a>
                                <h4 v-else class="text-center">@{{ video.title || video.name }}</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </channel-uploads>
    </div>
</div>
@endsection

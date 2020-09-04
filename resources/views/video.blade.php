@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if ($video->ownerIsCurrentUser())  
                <form action="{{ route('videos.update', $video->id) }}" method="POST">
                    @csrf @method('PUT')
                @endif

                    <div class="card-header">{{ $video->title }}</div>

                    <div class="card-body">
                        <video-js id="video" class="vjs-default-skin w-100" controls preload="auto" width="640" height="268">
                            <source src="{{ asset(Storage::url("videos/{$video->id}/{$video->id}.m3u8")) }}" type="application/x-mpegURL">
                        </video-js>


                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mt-3 font-weight-bold">
                                @if ($video->ownerIsCurrentUser())  
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ $video->title }}" name="title">
                                    @error('title')
                                    <span class="invalid-feedback font-weight-normal" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
    
                                @else
                                    {{ $video->title }}
                                @endif
                            </h6>

                            <vote-buttons :default_votes ='{{ $video->votes }}' entity_id ='{{ $video->id }}' entity_owner ='{{ $video->channel->user_id }}' entity_type="video"/>
                        </div>
                        <div>{{ $video->views }} {{ Str::plural('view', $video->views) }}</div>
                        <hr>

                        <div>
                            @if ($video->ownerIsCurrentUser())  
                                <textarea name="description" cols="3" rows="3" class="form-control @error('description') is-invalid @enderror">{{ $video->description }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <div class="text-right mt-4">
                                    <button class="btn btn-info btn-sm text-light" type="submit">Update video details</button>
                                </div>
                                @else
                                {{ $video->description }}
                            @endif
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <div class="media">
                                <img class="rounded-circle" src="https://picsum.photos/id/42/200/200" width="50" height="50" class="mr-3" alt="...">
                                <div class="media-body ml-2">
                                    <h5 class="mt-0 mb-0">
                                        {{ $video->channel->name }}
                                    </h5>
                                    <span class="small">Published on {{ $video->created_at->toFormattedDateString() }} </span>
                                </div>
                            </div>
                            <subscribe-button :channel="{{ $video->channel }}" :initial_subscriptions="{{ $video->channel->subscriptions }}"/>
                        </div>
                    </div>
                    @if ($video->ownerIsCurrentUser())  
                    </form>
                    @endif
                </div>
            </div>
            <div class="col-md-8">
                <comments-box :video ='{{ $video }}' />
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link href="{{ asset('css/video-js.min.css') }}" rel="stylesheet">
    <style>
        .w-full {
            width: 100% !important;
        }
        .w-80 {
            width: 80% !important;
        }

    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/video.min.js') }}"></script>
    <script> window.CURRENT_VIDEO = '{{$video->id}}' </script>
    <script src="{{asset('js/player.js')}}"></script>
@endsection
{{--             if (!this.newReply) return

            axios.post(`/videos/${this.video.id}/comments`, {
                body: this.newReply,
                video_id: this.video.id,
                comment_id: this.comment.id
            })
            .then(({data}) => {
                this.replies = {
                    ...this.replies,
                    data: [
                        data,
                        ...this.replies.data
                    ]
                }
                this.newReply = ''
            })
 --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ $channel->name  }}
                    <a href="{{ route('channels.upload', $channel->id) }}">Upload Video</a>
                </div>
                <div class="card-body">
                    @if (!$channel->ownerIsCurrentUser())
                        <div class="channel-avatar border m-auto"
                        style="width:100px;height:100px;background: url({{$channel->image()}}) center/cover">
                            <div class="camera btn btn-dark h-100 w-100 d-flex align-items-center">
                                <i class="mx-auto fas fa-camera fa-2x"></i>
                            </div>    
                        </div>

                        <div class="mt-3 text-center">
                            <h5>{{$channel->name}}</h5>
                            <p>{{$channel->description}}</p>
                            <subscribe-button :channel="{{ $channel }}" :initial_subscriptions="{{ $channel->subscriptions }}"/>
                        </div>
                    @endif

                    
                    @if ($channel->ownerIsCurrentUser())
                        <form id="update-form" action="{{route('channels.update', $channel->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PATCH')
                            <div class="form-group">
                                <div class="channel-avatar border m-auto @error('image') is-invalid @enderror" onclick="document.getElementById('image').click()"
                                style="width:100px;height:100px;background: url({{$channel->image()}}) center/cover">
                                    <div class="camera btn btn-dark h-100 w-100 d-flex align-items-center">
                                        <i class="mx-auto fas fa-camera fa-2x"></i>
                                    </div>    
                                </div>
                                @error('image')
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <input onchange="document.getElementById('update-form').submit()" type="file" name="image" id="image" class="d-none">
                            <div class="text-center">
                                <subscribe-button :channel="{{ $channel }}" :initial_subscriptions="{{ $channel->subscriptions }}"/>
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" name="name" value="{{$channel->name}}" type="text" class="form-control  @error('name') is-invalid @enderror">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="description" class="form-control-label">Description</label>
                                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{$channel->description}}</textarea>
                                
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <button class="btn btn-danger text-white">Update Channel</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Videos
                </div>

                <div class="card-body">

                    <table class="table">
                        <thead>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($videos as $video)
                                <tr>
                                    <td>
                                        <img width="40px" height="40px" src="{{ $video->thumbnail }}" alt="">
                                    </td>
                                    <td style="word-break: break-all">
                                        {{ $video->title }}
                                    </td>
                                    <td>
                                        {{ $video->views }}
                                    </td>
                                    <td>
                                        {{ $video->percentage === 100 ? 'Live' : 'Processing' }}
                                    </td>
                                    <td>
                                        @if($video->percentage === 100)
                                            <a href="{{ route('videos.show', $video->id) }}" class="btn btn-sm btn-info">
                                                View
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row justify-content-center">
                        {{ $videos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-dark mb-3">
                <div class="card-header">{{ __('Update Post') }}</div>

                <div class="card-body">
                    <div class="row mb-5">
                        @foreach ($post->postImages as $image)
                            <div class="col-lg-3">
                                <img src="{{asset('storage/posts').'/'.$image->photo_path }}" class="img-responsive img-thumbnail" style="width:200px;height:200px;">
                                <br>
                                <a href="{{ route('delete_post_image',$image->id) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </div>
                        @endforeach
                    </div>

                    <form action="{{ route('update_post',$post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="title" class="mb-2">Post Title</label>
                            <input type="text" value="{{ $post->title }}" name="title" id="title" placeholder="Post Title" required class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="mb-2">Post Description</label>
                            <textarea name="description" id="description" placeholder="Post Description" class="form-control" required cols="30" rows="3">{{ $post->description }}</textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="images" class="mb-2">Post Images</label>
                            <input type="file" multiple name="images[]" id="images" required class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

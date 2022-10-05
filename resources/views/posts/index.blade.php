@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-dark mb-3">
                <div class="card-header">{{ __('Upload New Post') }}</div>

                <div class="card-body">
                    <form action="{{ route('upload_post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="title" class="mb-2">Post Title</label>
                            <input type="text" name="title" id="title" placeholder="Post Title" required class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="mb-2">Post Description</label>
                            <textarea name="description" id="description" placeholder="Post Description" class="form-control" required cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="images" class="mb-2">Post Images</label>
                            <input type="file" multiple name="images[]" id="images" required class="form-control">
                        </div>

                        <div class="form-group mb-2">
                            <label for="hash" class="mb-2">Hashtags</label><br>
                            <input type="text" name="hashtag" data-role="tagsinput" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">All Posts</h3>
        </div>
        @foreach ($posts as $post)
            @include('posts.components.post')
        @endforeach
    </div>

    <div class="row">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection

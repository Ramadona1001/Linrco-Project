@extends('layouts.app')

@section('title','Post Search Result')

@section('content')
<div class="container">
    <h4>Post Search Result <span style="text-decoration: underline;font-weight:bold">#{{ $hashtag }}</span></h4>
    <div class="row">
        @foreach ($posts as $post)
            @include('posts.components.post')
        @endforeach
    </div>
</div>
@endsection

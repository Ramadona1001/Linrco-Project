@extends('layouts.app')

@section('title','Welcome')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">{{ __('Welcome') }}</div>

                <div class="card-body">
                    <p>Post Task</p>
                    <ul>
                        <li>User can create new post</li>
                        <li>User can delete post</li>
                        <li>Users can comment and like at the post</li>
                        <li>User can add hashtags on the posts and when click on he can review all posts that contains his hashtag</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title',$post->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="slideshow-container">
                    @foreach ($post->postImages as $image)
                    <div class="mySlides1">
                      <img src="{{ asset('storage/posts').'/'.$image->photo_path }}" style="width:100%;">
                    </div>
                    @endforeach
                    <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
                </div>
                <div class="card-body">
                  <h5 class="card-title">{{ $post->title }}</h5>
                  <p class="card-text">{{ $post->description }}</p>
                  <p class="card-text"><small class="text-muted"><i class="fa fa-clock"></i> {{ $post->created_at->diffForHumans() }}</small></p>
                    <p class="card-text"><small class="text-muted"><i class="fa fa-thumbs-up"></i> <span id="likesCount">{{ count($post->postLikes) }}</span> - <i class="fa fa-comments"></i> <span class="commentsCount">{{ count($post->postComments) }}</span></small></p>
                </div>
                <div class="card-footer">
                    <h4>#Hashtags</h4>
                    @foreach ($post->postHashTags as $hash)
                        <a href="{{ route('hashtagpost_post',$hash->hashtag) }}" class="btn btn-info btn-sm">{{ $hash->hashtag }}</a>
                    @endforeach
                    <hr>
                    <div style="font-size: 20px;">
                        <a href="#" class="text-blue user-dislike"><i class="fa fa-thumbs-up"></i></a>
                        <a href="#" class="text-black user-like"><i class="fa fa-thumbs-up"></i></a>
                        <span class="likes"></span>
                    </div>
                </div>
              </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-lg-12">
            <form action="" method="post">
                @csrf
                <textarea name="comment" required id="comment" cols="30" rows="2" class="form-control" placeholder="Write Comment" required></textarea>
                <button type="submit" id="comment-post" class="btn btn-primary mt-3">Comment</button>
            </form>
        </div>
        <h3 class="text-center mb-3">All Comments (<span class="commentsCount">{{ count($post->postComments) }}</span>)</h3>
        <ul style="list-style: none" id="comments">
            @foreach ($post->postComments as $comment)
                <li class="alert alert-secondary comment-{{ $comment->id }}">
                    {{ $comment->user->name }} : {{ $comment->comment }}
                    @if (auth()->user()->id == $comment->user->id)
                        <a href="#" data-id="{{ $comment->id }}" class="btn btn-danger btn-sm delete-comment" style="float:right;"><i class="fa fa-trash"></i></a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getLikes() {
            $.ajax({
                type:'get',
                url:"{{ route('get_post_likes') }}",
                data:{post:{{ $post->id }}},
                success:function(data){
                    if (data.includes({{ auth()->user()->id }})) {
                        $('.user-like').hide();
                        $('.user-dislike').show();
                    }else{
                        $('.user-like').show();
                        $('.user-dislike').hide();
                    }
                    $('#likesCount').text(data.length);
                    $('.likes').text(data.length+' like this');
                }
            });
        }

        getLikes();


        $('.user-like').on('click',function(){
            $.ajax({
                type:'POST',
                url:"{{ route('like_post') }}",
                data:{post:{{ $post->id }}},
                success:function(data){
                    if (data == 'success') {
                        getLikes();
                        $('.user-like').hide();
                        $('.user-dislike').show();
                    }
                }
            });
        });

        $('.user-dislike').on('click',function(){
            $.ajax({
                type:'POST',
                url:"{{ route('dislike_post') }}",
                data:{post:{{ $post->id }}},
                success:function(data){
                    if (data == 'success') {
                        getLikes();
                        $('.user-like').show();
                        $('.user-dislike').hide();
                    }
                }
            });
        });


        function getComments() {
            $.ajax({
                type:'get',
                url:"{{ route('get_post_comments') }}",
                data:{post:{{ $post->id }}},
                success:function(data){
                    $('.commentsCount').text(data.length);
                }
            });
        }

        getComments();

        $('#comment-post').on('click',function(e){
            e.preventDefault();
            $.ajax({
                type:'POST',
                url:"{{ route('comment_post') }}",
                data:{
                    post:{{ $post->id }},
                    comment:$('#comment').val()
                },
                success:function(data){
                    console.log(data);
                    var commentHtml = '';
                    commentHtml += '<li class="alert alert-secondary comment-'+data.id+'" >';
                    commentHtml += data.user.name+' : ';
                    commentHtml += data.comment;
                    commentHtml += (data.user.id == "{{ auth()->user()->id }}") ? '<a href="#" data-id="'+data.id+'" class="btn btn-danger btn-sm delete-comment" style="float:right;"><i class="fa fa-trash"></i></a>' : '';
                    commentHtml += '</li>';
                    $('#comments').append(commentHtml);
                    $('#comment').val('');
                    getComments();
                }
            });
        });

        $( document ).ajaxComplete(function() {
            $('.delete-comment').on('click',function(){
            var id = $(this).data('id');
            $('.comment-'+id).remove();
                $.ajax({
                    type:'POST',
                    url:"{{ route('delete_comment') }}",
                    data:{
                        comment:id,
                    },
                    success:function(data){
                        getComments();
                    }
                });
            });
        });



    });
</script>
@endsection

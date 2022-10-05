<div class="col-md-4 mt-3">
    <div class="card mb-3">
        <div class="row g-0">
          <div class="col-md-12">
            <div class="card-body">
              <h5 class="card-title">
                <a href="{{ route('single_post',$post->id) }}">{{ $post->title }}</a>
              </h5>
              <p class="card-text">{{ Str::substr($post->description, 0, 20).' ...' }}</p>
              <p class="card-text"><small class="text-muted"><i class="fa fa-clock"></i> {{ $post->created_at->diffForHumans() }}</small></p>
              <p class="card-text"><small class="text-muted"><i class="fa fa-thumbs-up"></i> {{ count($post->postLikes) }} - <i class="fa fa-comments"></i> {{ count($post->postComments) }}</small></p>
            </div>
            <div class="card-footer">
                @if (auth()->user()->id == $post->user_id)
                    <a href="{{ route('edit_post',$post->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('delete_post',$post->id) }}" onclick="return confirm('Are You Sure?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                @endif
            </div>
          </div>
        </div>
    </div>
</div>

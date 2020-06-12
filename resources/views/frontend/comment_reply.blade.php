
<!------ Include the above in your HEAD tag ---------->

@if(isset(Auth::user()->user_name))
@foreach($comments as $comment)



    {{--<div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <strong>{{ $comment->user->user_name }}</strong>
        <p>{{ $comment->comment }}</p>
        <form class="default_form" id="reply-blog-comment" method="POST" action="{{ url('reply-blog-comment') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" name="comment" class="form-control" />
                <input type="hidden" name="parent_id" value="{{$articles->id }}" />
                <input type="hidden" name="blog_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-warning">Reply</button>
            </div>
        </form>
        @include('frontend.comment_reply', ['comments' => $comment->replies])
    </div>--}}

    <div class="container">
    <div class="card card-inner">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <strong>{{ $comment->user->user_name }}</strong>

                    <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
                    <p class="text-secondary text-center">15 Minutes Ago</p>
                </div>
                <div class="col-md-10">
                    <p>{{ $comment->comment }}</p>


                    <form class="default_form" id="reply-blog-comment" method="POST" action="{{ url('reply-blog-comment') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="comment" class="form-control" />
                            <input type="hidden" name="parent_id" value="{{$articles->id }}" />
                            <input type="hidden" name="blog_id" value="{{ $comment->id }}" />
                        </div>
                        <div class="form-group">
                            <button type="submit"  class="float-right btn btn-outline-primary ml-2">Reply</button>
                        </div>
                    </form>
                    @include('frontend.comment_reply', ['comments' => $comment->replies])
                </div>
            </div>
        </div>
      </div>
    </div>
@endforeach
@endif








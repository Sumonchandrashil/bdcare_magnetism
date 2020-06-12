@include('frontend.header')

<!-- ###########################
    BLOG TOP SECTION
########################### -->

<section class="blogTop">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="blogTopLeft">
                    <h1>The BdCare Blog</h1>
                </div>
            </div>
            {{--<div class="col-lg-6 col-md-6 col-xs-12">
                <div class="blogTopRight">
                    <form>
                        <input type="text" name="blog" id="blogSearch" placeholder="Search your blog...">
                    </form>
                </div>
            </div>--}}
        </div>
    </div>
</section>


<!-- ###########################
    BLOG SECTION
########################### -->


<section class="blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-xs-12">
                <div class="blogSection">
                    <a href="#">
                        <h1>
                            {{$articles->title}}
                        </h1>
                    </a>
                    <a href="#">
                        <h3>
                            Posted on {{date('d-M',strtotime($articles->date))}}, {{date('Y',strtotime($articles->date))}} by {{$articles->get_doctor ? $articles->get_doctor->doctor_name : 'Not Set' }}
                        </h3>
                    </a>
                    <p><img src="{{url('public/uploads/health_article/'.$articles->image)}}" onerror="this.onerror=null; this.src='{!! asset('assets/frontend/images/no_image1.png') !!}'" class="img-thumbnail"></p>
                    <p style="text-align: justify">
                        {!! $articles->description !!}
                    </p>

                    <div class="posted-by">
                        <div class="posted-by__title">
                            Posted By
                        </div>
                        <h6>{{$articles->get_doctor ? $articles->get_doctor->doctor_name : 'Not Set' }}</h6>
                        <div class="row">
                                <div id="blog">
                                    <div class="doctor-specialty">

                                        <div>
                                            <h6>Degree</h6>
                                            <ul>
                                                @foreach($articles->get_doctor->get_degree as $degrees)
                                                    <li><i class="fas fa-check"></i> {{$degrees->get_degree->degree_name}}</li>
                                                @endforeach
                                            </ul>

                                        </div>

                                        <div>
                                            <h6>Specialty</h6>
                                            <ul>
                                                @foreach($articles->get_doctor->get_speciality as $spaciality)
                                                    <li><i class="fas fa-check"></i> {{$spaciality->get_speciality->speciality_name}}</li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>


                    @if(isset(Auth::user()->user_name))
                        @foreach($comments as $comment)

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
                                                <p>
                                                    @if($comment->replies->count() > 0)
                                                         @include('frontend.comment_reply', ['comments' => $comment->replies])
                                                    @endif
                                                </p>
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
                                              {{--  @include('frontend.comment_reply', ['comments' => $comment->replies])--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <form class="default_form" id="comments" method="POST" action="{{ url('blog-comment') }}">
                            {{ csrf_field() }}
                            <div>
                                <p>Comment :</p>
                                <textarea rows="4", cols="85"  name="comment"></textarea>
                                <input type="hidden" name="blog_id" value="{{ $articles->id }}" />
                            </div>
                            <button type="submit" class="btn btn-primary">Add Comment</button>
                         </form>
                    @endif

                </div>
            </div>
            {{--<div class="col-lg-4 col-md-4 col-xs-12">
                <div class="blogSidebar">
                    <div class="subscribeBox">
                        <h1>Subscribe to Blog</h1>
                        <p>
                            Our e-mail updates will keep you informed on our company, new products, stories from the millions of people we help live healthier longer lives.
                        </p>
                        <form action="#">
                            <input type="text" name="" class="subsField">
                            <input type="submit" name="" value="Subscribe" class="subsBtn">
                        </form>
                    </div>
                    <div class="blog_search">
                        <h1>SEARCH BDCARE BLOG</h1>
                        <input type="text" name="" placeholder="Search..." class="BlogsearchField">
                    </div>

                </div>
            </div>--}}
        </div>
    </div>
</section>




@include('frontend.footer')

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
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="blogTopRight">
                    <form action="{{ route('blog-filtering') }}" method="GET">
                        <div class="form-group" style="display:flex; align-items: flex-end">
                            <input type="text" name="filter_value" id="blogSearch" placeholder="Search your blog..." autocomplete="off" required>
                            <button type="submit" class="btn btn-warning" style="height: 40px; border-radius:0; "><i class="fas fa-search" style="color: #ffffff"></i></button>
                        </div>
                    </form>

                </div>
            </div>
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

                    <hr class="blogHrStyle">

                        <div>
                            @if(count($articles) > 0)
                                @foreach($articles as $article)
                                    <div  style="padding: 0 0 15px;">
                                        <a href="{{url('blog_single/'.$article->id)}}">
                                            <h1>{{ $article->title }}</h1>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <h3>
                                                {{ date('d-M-Y',strtotime($article->date)) }}, by {{$article->get_doctor ? $article->get_doctor->doctor_name : 'Not Found' }}
                                            </h3>
                                        </a>
                                        <p>
                                            <img src="{{url('public/uploads/health_article/'.$article->image)}}" onerror="this.onerror=null; this.src='{!! asset('assets/frontend/images/no_image1.png') !!}'" class="img-thumbnail">
                                        </p>
                                        <p>
                                            {!! substr($article->description, 0, 700) !!}
                                            <a style="color: #0089af; font-size: 14px; text-decoration: none; padding: 3px 5px;margin: 0 10px; border: 1px solid #0089af;" href="{{url('blog_single/'.$article->id)}}">Read More</a>
                                        </p>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                      {{--  pagintion--}}
                        {{ $articles->links('vendor.pagination.bootstrap-4') }}
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
                    --}}{{--<div class="blog_search">
                        <h1>SEARCH BDCARE BLOG</h1>
                        <input type="text" name="" placeholder="Search..." class="BlogsearchField">
                    </div>--}}{{--
                    --}}{{--<div class="blog_archives">
                        <h1>BdCare Blog Archive</h1>
                        <ul>
                            <li>
                                <a href="#">
                                    January 2018 (3)
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    February 2018 (20)
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    March 2018 (2)
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    April 2018 (24)
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    January 2018 (3)
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    February 2018 (20)
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    March 2018 (2)
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    April 2018 (24)
                                </a>
                            </li>

                        </ul>
                    </div>--}}{{--
                </div>
            </div>--}}
        </div>
    </div>
</section>




@include('frontend.footer')

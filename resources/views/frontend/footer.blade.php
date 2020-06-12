<!-- ###########################
    WIDGET SECTION
########################### -->
<section class="footer" style="height: 30px">
    <div class="container">
        <div class="row">

        </div>
    </div>
</section>


<section class="widget">
  <div class="container-fuild">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-xs-12">
        <div class="widgetArea">

          <div class="widgetLogo">

            <img src="{!! asset('assets/frontend/images/footer-logo.png') !!}">
          </div>
            <br>
            <div class="widgetLogo">
                <h3><a href="{{url('about-us')}}">About Us</a></h3>
                <p>
                    Bdcare is online healthcare startup from Bangladesh, which is the first and largest initiative.
                </p>
            </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-3 col-xs-12">
        <div class="widgetArea">
          <ul>
            <li>
              <span>For Patient</span>
            </li>
            <li>
              <a href="{{ url('ask-doctor') }}" >
                Ask free health questions
              </a>
            </li>
            <li>
              <a href="{{ url('hospitals-list') }}">
                Search for clinics
              </a>
            </li>
            <li>
              <a href="{{ url('book-appointment') }}" >
                Search for doctors
              </a>
            </li>
            <li>
              <a href="{{ url('patient-referral') }}">
                Patient referral
              </a>
            </li>
            <li>
              <a href="{{ url('online-consult') }}">
                Consult a doctor
              </a>
            </li>
              <li>
                  <a href="{{ url('more-packages') }}">
                      Book Checkup
                  </a>
              </li>
              <li>
                  <a href="{{ url('emergency-health-service') }}">
                      Get Emergency Services
                  </a>
              </li>
              <li>
                      <a href="{{ URL::to('blog') }}">
                          Read Health Article
                      </a>
              </li>
            <li>
              <a href="https://play.google.com/store/apps/details?id=com.iventure.bdcare" target="_blank">
                Health App
              </a>
            </li>
          </ul>
        </div>
      </div>
        <?php
        if(isset(Auth::user()->role_id))
            {
                $user_role = Auth::user()->role_id;
            }
        else{
            $user_role = 0;
        }

       ?>
        <div class="col-lg-2 col-md-2 col-xs-12">
            <div class="widgetArea">
                <ul>
                    <li>
                        <span>For Doctor</span>
                    </li>
                    <li>
                        <a <?php if($user_role == 3){?> href="{{url('doctors_profile-backend')}}" <?php }else{?> href="{{ url('register') }}" <?php } ?>>
                            Create Profile
                        </a>
                    </li>
                    <!-- <li>
                        {{--<a <?php if($user_role == 3){?> href="{{url('OnlineConsult')}}" <?php }else{?> href="{{ url('online-consult') }}" <?php } ?>>--}}
                            {{--Response to Patient Queries--}}
                        {{--</a>--}}
                    {{--</li> -->--}}  -->
                    <li>
                        <a
                            <?php if($user_role == 3){ ?>
                            href="{{url('add-health-article')}}"
                            <?php }else{?>
                            href="{{ url('blog') }}" <?php } ?>>
                            Health article
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}">
                            BDCare Reach
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-xs-12">
            <div class="widgetArea">
            <ul>
                <li>
                    <span>More</span>
                </li>
                <li>
                    <a href="{{url('about-us')}}">
                        About Us
                    </a>
                </li>
                {{--<li>--}}
                    {{--<a href="#" onclick="alert('Not Set Yet --- Coming Soon')">--}}
                        {{--Help--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li>
                    <a href="{{url('contact-us')}}" >
                        Contact Us
                    </a>
                </li>
                <li>

                    <a href="{{url('blog')}}" >
                        Blog
                    </a>
                </li>
                <li>

                    <a href="{{url('terms-condition')}}" >
                        Terms & Conditions
                    </a>
                </li>
                <li>
                    <a href="{{url('privacy-policy')}}" >
                        Privacy Policy
                    </a>
                </li>

            </ul>
            </div>
        </div>

        <div class="col-lg-2 col-md-2 col-xs-12">
            <div class="widgetArea">
                <ul>
                    <li>
                        <span>Social</span>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/bdcare2019" target="_blank">
                            Facebook
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/channel/UC_IiaP-ZlOYzy0Yh9qtEukA?view_as=subscriber" target="_blank">
                            Youtube
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/Bdcare1" target="_blank">
                            Twitter
                        </a>
                    </li>
                    {{--<li>--}}
                        {{--<a href="#" target="_blank">--}}
                            {{--Instagram--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li>
                        <a href="https://linkedin.com/in/bd-care-b49751185 " target="_blank">
                            LinkedIn
                        </a>
                    </li>

                </ul>

            </div>
        </div>
    </div>
  </div>
</section>

<!-- ###########################
    FOOTER SECTION
########################### -->

<section class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-4 col-xs-12">
        <h3><span>©</span> {{ __('messages.bdcare') }} (Pvt.Ltd). All Right reserved</h3>
      </div>
        <div class="col-lg-4 col-md-4 col-xs-12"></div>
        <div class="col-lg-4 col-md-4 col-xs-12">
        <h3>Developed by <a target="_blank" href="http://iventurebd.com/"><img width="90px" src="{{url('img/I-Venture-LOGO-Main-File-2.png')}}"></a></h3>
      </div>
    </div>
  </div>
</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="{!! asset('assets/frontend/js/slick.js') !!}"></script>
<script src="{!! asset('assets/frontend/js/bootstrap.min.js') !!}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script type="text/javascript">

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

        @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;
        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;
        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif

  $(document).ready(function() {
      $('.select2').select2();
  });

  $(document).ready(function(){
        $('.healthSlider').slick({
          slidesToShow: 3,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 2000,
          dots: true,
          infinite: true,
          speed: 500,
          responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                  ]
        });
      });

      $(document).ready(function(){
        $('.investorSlider').slick({
          slidesToShow: 5,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 2000,
          dots: true,
          infinite: true,
          speed: 500,
          responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                  ]
        });
      });


</script>

  </body>
</html>

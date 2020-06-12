@include('frontend.header')


<!-- ###########################
    ASK A DOCTOR SECTION
########################### -->


<section class="askDoctor">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="askDoctorLeft">
                    @if(session()->has('successMsg'))
                        <div class="m-alert m-alert--outline alert alert-success alert-dismissible animated fadeIn"
                             role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <span>{{ session()->get('successMsg') }}</span>
                        </div>
                    @endif
                    @if(session()->has('errorMsg'))
                        <div class="m-alert m-alert--outline alert alert-danger alert-dismissible animated fadeIn"
                             role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <span>{{ session()->get('errorMsg') }}</span>
                        </div>
                    @endif
                    <form action="{{url('ask_doctor')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h1>Ask a Doctor</h1>
                        <h3>Tell us your symptom or health problem </h3>
                        <textarea name="title" class="symptom_search"
                                  placeholder="Eg: fever, headache,... (Min 10 Characters)"></textarea>
                        <div class="selectSpeciality">
                            <h3>Select Specialty</h3>
                        </div>
                        <div class="specialityPanel">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="select_symptom">
                                        @foreach($specialistData as $specialist)
                                            <ul>
                                                <li>
                                                    <input type="checkbox" name="Symptom[]"
                                                           value="{{ $specialist->speciality_name }}">
                                                    <span>{{ $specialist->speciality_name }}</span>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h2>Email Address</h2>
                        <input type="email" name="email" class="mobBtn"
                               placeholder="Email will be sent to the given address" required>
                        <input type="submit" value="Submit" class="submitQuestion">
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="askDoctorRight">
                    <h1>
                        <i class="fas fa-shield-alt"></i>
                    </h1>
                    <p>Private & Secure</p>
                    <ul class="custom_badge_icons">
                        <li>
                            <h1>
                                <i class="far fa-thumbs-up"></i>
                            </h1>
                            <p>1 Million+ Users</p>
                        </li>
                        <li>
                            <h1>
                                <i class="fas fa-user-md"></i>
                            </h1>
                            <p>Verified Doctors</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="askDoctor">
    <div class="container" style="padding: 15px;">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 article-comments-title">
                <h3 align="center"> Previous Question & Answer </h3>
            </div>
        </div>
        <div class="form-group">
            <div class="article-content">
                @foreach($askList as $question)
                    <div class="col-lg-12 col-md-12 col-xs-12 comments-row" style="background-color: white" align="left">
                        <div class="comments-block">
                            <p><strong>Question :</strong> {{ $question->title }}</p>
                            @if( $question->reply )
                                <span><strong style="color: #0a6aa1">Reply :</strong> {{$question->reply}} </span>
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="article-pagination">
                    {{ $askList->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

@include('frontend.footer')

<script>

    $(document).ready(function () {

        $(".selectSpeciality").click(function () {
            $(".specialityPanel").slideToggle('slow', function () {

            });
        });

    });

</script>

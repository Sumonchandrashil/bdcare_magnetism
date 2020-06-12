@include('frontend.header')

<!-- ###########################
    ONLINE CONSULT SECTION
########################### -->

<div class="container-fluid">
    <div class="talk-doctor">
        <div class="single-page-header">
            <div class="container">
                <div class="page-title">
                    <h3>Talk to a Doctor from anywhere.</h3>
                    <h5>Consult privately with top doctors fees starting at TK 300</h5>
                    <div class="consult-btn">
                        <a href="{{url('appointment-online')}}">Consult Now</a>
                    </div>
                    <div class="return-policy">
                        <h6>Privacy Guaranteed</h6>
                        <h6>Flexibale refund policy</h6>
                    </div>
                </div>
                <div class="page-header__icon">
                    <img src="{{ asset('assets/frontend/images/page-header/talk-doctor.png') }}">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="how-work-content">
                <div class="row">
                    <div class="col-md-12">
                        <h3>How it works?</h3>
                    </div>
                    <ul>
                        <li class="how-work__items">
                            <p>Explain your health concern to find appropriate doctors.</p>
                        </li>
                        <li class="how-work__items">
                            <p>Always affordable pay lesser fees than physical appointements.</p>
                        </li>
                        <li class="how-work__items">
                            <p>Show your health recored after conversation, doctor will see your health records.</p>
                        </li>
                        <li class="how-work__items">
                            <p>Get e-prescription pay lesser fees than physical appointements.</p>
                        </li>
                        <li class="how-work__items">
                            <p>Free Follow Up, Ask free follow up questions for 2days after the chat ends.</p>
                        </li>
                    </ul>
                </div>
                <div class="download-apps">
                    <a href="https://play.google.com/store/apps/details?id=com.iventure.bdcare">
                        <h1>Download Apps</h1>
                        <img src="{!! asset('assets/frontend/images/download-app.png') !!}">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@include('frontend.footer')

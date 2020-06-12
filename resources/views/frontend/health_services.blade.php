@include('frontend.header')


<!-- ###########################
    HEALTH SERVICES SECTION
########################### -->

<section class="healthServices">
    <div class="single-page-header emergency-service-header">
        <div class="container">
            <div class="page-title">
                <h3>Emergency <br> <strong>Health Service</strong></h3>
            </div>
            <div class="page-header__icon">
                <img src="{{ asset('assets/frontend/images/page-header/health-service.png') }}">
            </div>
        </div>
    </div>
    <div class="container emergency-health-service">
        <div class="health-service-content">
            <div class="row">
                <div class="col-md-12">
                    <h1>FAST, EASY AND RELIABLE</h1>
                </div>
                <?php foreach ($health_service as $service_row) { ?>
                <div class="col-md-4">
                    <div class="service-item">
                        <p>To confirm an ambulance booking, please fill up the e-form. We will get back soon to you.</p>
                        <div class="service-photo">
                            <?php if ($service_row->image != ''){?>
                            <img src="{{url('/public').$service_row->image}}">
                            <?php }else{?>
                            <img src="{!! asset('assets/frontend/images/icon1.png') !!}">
                            <?php } ?>
                        </div>
                        <h5>{{$service_row->name}}</h5>
                        <div class="book-btn">
                            <a href="{{url('service_details').'/'.$service_row->id}}">Book</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<br>
@include('frontend.footer')

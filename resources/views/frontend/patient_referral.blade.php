@include('frontend.header')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<!-- ###########################
    PATIENT REFERRAL SECTION
########################### -->


<div class="container-fluid patient-referral">
    <div class="container">
        <div class="referral-to">
            <div class="row">
                <div class="col-md-6">
                    <div class="refer-to__icon">
                        <img src="{{ asset('assets/frontend/images/page-header/referral.png') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>We refer to</h3>
                    <p>30+ world class hospitals with</p>
                    <p>900+ Experienced doctors in</p>
                    <h4>India, Singapore, Thailand</h4>
                </div>
            </div>
        </div>
        <div class="referral-facilities">
            {{--<div class="row">--}}
            {{--<div class="col-md-6">--}}
            {{--<div class="facility-list">--}}
            {{--<ul>--}}
            {{--<li><i class="fas fa-check"></i><span>Refer to world class hospitals (JCI accredited)</span></li>--}}
            {{--<li><i class="fas fa-check"></i><span>Most experienced and renowned doctors</span></li>--}}
            {{--<li><i class="fas fa-check"></i><span>Online report assessment</span></li>--}}
            {{--<li><i class="fas fa-check"></i><span>Doctor opinion and cost evaluation is FREE</span></li>--}}
            {{--<li><i class="fas fa-check"></i><span>Airport pickup and drop for FREE</span></li>--}}
            {{--<li><i class="fas fa-check"></i><span>Translation to solve language difficulties for FREE</span></li>--}}
            {{--<li><i class="fas fa-check"></i><span>Online discussion with doctors after returning home</span></li>--}}
            {{--<li><i class="fas fa-check"></i><span>Comperehansive and well treatment is guaranteed</span></li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-6">--}}
            {{--<div class="ensurity-title">--}}
            {{--<h1>You will never be neglected !</h1>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="row">
                <div class="col-md-12">
                    <div class="ensurity-title">
                        <h2>You will never be neglected !</h2>
                        <h5>We are always with you to support every step of your treatment</h5>
                        <img src="{{ asset('assets/frontend/images/icon/referral-icon.png') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="comprehensive-treatment">
            <div class="row">
                <div class="col-md-12">
                    <h2>Comprehensive and better treatment is <span>Guaranteed !</span></h2>
                </div>
                <div class="col-md-6">
                    <div class="affiliate-hospitals">
                        <h5>Our Affiliated Hospitals</h5>
                        <p>Farref Park Hospital, Singapore Raffles Hospital, Singapore Vejthani Hospital, Thailand
                            Samitivej Hosital, Thailand Fortis Hospital, Bangalore, India Medanta Medicare, Delhi,
                            India</p>
                        <h6>and many more...</h6>
                        <div class="more-btn">
                            <a href="#" data-toggle="modal" data-target="#hospitalModal">See Hospitals</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="patient-block">
                        <h5>Please fill up the form and attach latest diagnostic reports.</h5>
                        <div class="more-btn">
                            <a href="{{ url('foreign-hospitals') }}">Send patients details</a>
                        </div>
                        <div class="note">
                            <span>We will get back with </span> cost assessment and treatment plan.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="hospitalModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Foreign Hospitals</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-hover table-responsive-lg table-scrollable"
                               id="m_table_1">
                            <thead>
                            <tr>
                                <th>Country</th>
                                <th>Hospital Name</th>
                                <th>Address</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($foreignHospitals as $row)
                                <tr>
                                    <td>{{$row->country_name}}</td>
                                    <td>{{$row->hospital_name}}</td>
                                    <td>{{$row->address}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#m_table_1').DataTable({
            "order": [[0, "desc"]]
        });
    });
</script>

@include('frontend.footer')

@include('frontend.header')

<div class="foreign-hospitals">
    <div class="single-page-header">
        <div class="container">
            <div class="page-title">
                <h3>Treatment Referral to foreign hospitals</h3>
            </div>
            <div class="page-header__icon">
                <img src="{{ asset('assets/frontend/images/page-header/foreign-hospital.png') }}">
            </div>
        </div>
    </div>
    <div class="foreign-hospitals__content">
        <div class="content__title">
            <h5>See our affiliated Hospitals</h5>
            <h4>Procedure</h4>
        </div>
        <div class="content-sammury">
            <p>Find our affiliated Hospital. If you determind to reach specific one its okay or we may help you to find
                bette one as per your treatment requirement. Your are request to follow the steps below:</p>
            <h6>a. Fill up the form and attached all recent medical reports.</h6>
            <h6>b. Read terms and conditions carefully before submit the form.</h6>
        </div>
        <div class="content-form">
            <form action="{{url('referral_data')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="content-form__row">
                    <div class="col3 left">
                        <div class="form-group aligment">
                            <label>1. Name of the patient</label>
                            <input type="text" name="patient_name" placeholder="write patients name"
                                   class="form-control" required>
                        </div>
                    </div>
                    <div class="col1 right">
                        <div class="form-group aligment">
                            <label>2. Age</label>
                            <input type="number" name="patient_age" placeholder="patients age" class="form-control"
                                   required>
                        </div>
                    </div>
                </div>
                <div class="content-form__row">
                    <div class="col3 left">
                        <div class="form-group aligment">
                            <label>3. Name of the care giver</label>
                            <input type="text" name="care_giver_name" placeholder="care giver name"
                                   class="form-control" required>
                        </div>
                    </div>
                    <div class="col1 right">
                        <div class="form-group aligment">
                            <label>4. Age</label>
                            <input type="number" name="care_giver_age" placeholder="care giver age"
                                   class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="content-form__row">
                    <div class="col3 left">
                        <div class="form-group aligment">
                            <label>5. Patient passport no.</label>
                            <input type="text" name="passport_no" placeholder="passport no." class="form-control"
                                   required>
                        </div>
                    </div>
                    <div class="col1 right">
                        <div class="form-group aligment justify-col">
                            <label>6. Wheel chair needed ?</label>
                            <span><input type="radio" name="wheel_chair" value="1" placeholder="need wheel chair?"> Yes</span>
                            <span><input type="radio" name="wheel_chair" value="0"
                                         placeholder="need wheel chair?"> No</span>
                        </div>
                    </div>
                </div>
                <div class="content-form__row">
                    <div class="form-group justify-left-col">
                        <label>7. Address</label>
                        <textarea name="address" rows="3" class="form-control right" required></textarea>
                    </div>
                </div>
                <div class="content-form__row">
                    <div class="col3 left">
                        <div class="form-group aligment">
                            <label>8. Mobile Number</label>
                            <input type="number" name="mobile_number" placeholder="mobile number" class="form-control"
                                   required>
                        </div>
                    </div>
                    <div class="col1 right">
                        <div class="form-group aligment">
                            <label>9. Email</label>
                            <input type="email" name="email" placeholder="email" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="content-form__row">
                    <div class="col3 left">
                        <div class="form-group aligment">
                            <label>10. Posible date of travel</label>
                            <input type="date" name="date_of_travel" placeholder="date to visit your doctor"
                                   class="form-control" required>
                        </div>
                    </div>
                    <div class="col1 right">
                        <div class="form-group aligment justify-col">
                            <label>11. Prefered Country</label>
                            <select class="form-control select2 search" name="country_id" id="country_id">
                                <option>---- Please Select ----</option>
                                @foreach ($countries as $key=>$country)
                                    <option
                                        value="{{ $country->id }}">{{$country->country_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="content-form__row">
                    <div class="form-group justify-left-col">
                        <label class="left">12. Prefered hospital (if any)</label>
                        <select class="form-control " name="foreign_hospital_id" id="foreign_hospital_id">
                            <option>---- Please Select ----</option>
                        </select>
                    </div>
                </div>
                <div class="content-form__row">
                    <div class="form-group">
                        <label>13. Attached all medical report</label>
                        <input type="file" name="medical_report" placeholder="upload all medical report"
                               class="form-control">
                    </div>
                </div>
                <div class="terms-conditions">
                    <h5>Read <a href="javascript:void(0)">Terms & Condition</a> carefully before confirm submit to know this service well
                    </h5>
                </div>

                <div class="content-submit" id="submit_button">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function getForeignHospitals(val) {
        $.ajax({
            type: "POST",
            url: "get_district.php",
            data: 'country_id=' + val,
            success: function (data) {
                $("#district-list").html(data);
            }
        });
    }
</script>

<script type="text/javascript">

    $(document).on("change", "#country_id", function () {
        var action = "{{ URL::to('getForeignHospitals') }}";
        var country_id = $('#country_id').val();
        // alert(country_id);

        var token = $('input[name=_token]').val();

        if (country_id) {
            $.ajax({
                type: 'GET',
                url: action,
                data: {'country_id': country_id, '_token': token},
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#foreign_hospital_id').html('<option value="">---- Please Select ----</option>');
                    $.each(data, function (key, value) {
                        $('#foreign_hospital_id').append('<option name="foreign_hospital_id" id="foreign_hospital_id" value="' + value.id + '">' + value.hospital_name + '</option>');
                    });
                }
            });
        } else {
            $('#foreign_hospital_id').html('<option value="">---- Please Select ----</option>');
        }
    });
</script>

@include('frontend.footer')

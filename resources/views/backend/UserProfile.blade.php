<div class="profileContent" style="padding: 50px">

    @if(session()->has('successMsg'))
        <div class="m-alert m-alert--outline alert alert-success alert-dismissible animated fadeIn" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            <span>{{ session()->get('successMsg') }}</span>
        </div>
    @endif
    @if(session()->has('errorMsg'))
        <div class="m-alert m-alert--outline alert alert-danger alert-dismissible animated fadeIn" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            <span>{{ session()->get('errorMsg') }}</span>
        </div>
    @endif


    <form action="{{ url('UserProfileStore') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="form-control" name="id" placeholder="Name" value="{{$user_data->id}}">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="UserName">UserName</label>
                <input type="text" id="UserName" class="form-control" name="user_name" placeholder="Name"
                       value="{{$user_data->user_name}}">
            </div>
            <div class="form-group col-md-6">
                <label for="Email">Email</label>
                <input type="email" id="Email" class="form-control" name="email" placeholder="Ex: admin@gmail.com"
                       value="{{$user_data->email}}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="Contact">Contact No</label>
                <input type="number" id="Contact" class="form-control" name="mobile" placeholder="01712234567"
                       value="{{$user_data->mobile}}">
            </div>

            <div class="form-group col-md-6">
                <label for="Password">Password</label>
                <input type="password" id="Password" class="form-control" name="password" placeholder="Password"
                       value="">
            </div>

        </div>

        <div class="form-row">

            <div class="form-group col-md-6">
                <label for="Password2">Changed Password</label>
                <input type="password" id="Password2" class="form-control" name="password_confirmation"
                       placeholder="Confirm Password" value="">
            </div>

            <div class="form-group col-md-6">
                <label for="Profile">Add Profile Photo</label>
                <input type="file" id="Profile" class="form-control" name="user_photo">
            </div>

        </div>


        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <?php
    if(Auth::user()->role_id == 3){
    $status = DB::table('doctors_datas')->where('created_by', Auth::user()->id)->first()->status;
    if($status == 0)
    {
    ?>
    <h5 align="center" style="color: darkred">"Your Profile is not "Active". Please Contact BDCare officials:
        01886555000"</h5>
    <?php
    }
    elseif($status == 1){
    ?>
    <h5 class="active-notification"><i class="fas fa-check-circle"></i> Your Profile is Active Now</h5>
    <?php
    }
    }
    ?>

    <?php
    if(Auth::user()->role_id == 3){
    $premium = DB::table('doctors_datas')->where('created_by', Auth::user()->id)->first()->premium;
    if($premium == 0)
    {
    ?>
    <h5 align="center" style="color: darkred">"Your Profile is not "Premium". Contact BDCare officials:
        01886555000 for premium account."<br><a href="#" data-toggle="modal" data-target="#terms_reach">Terms and
            Conditions</a></h5>
    <?php
    }
    elseif($premium == 1){
    ?>
    <h5 class="active-notification"><i class="fas fa-check-circle"></i> Premium Account </h5>
<?php
}
}
?>

<!-- Modal -->
    <div class="modal fade" id="terms_reach" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Bdcare Reach</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bdcare Reach is a paid service for promotion of Doctors&rsquo; Practice. Please see the following
                        conditions to earn this service.</p>
                    <ol>
                        <li>Reach is a sponsored part of Bdcare where paid Doctors&rsquo; profile will show on the top
                            of search result. Suppose Dr &lsquo;Z&rsquo; is practicing as dentist at Rampura. The
                            sponsored profile will show on top of search result if anyone searching for dentist for
                            Rampura-Banasree area.
                        </li>
                        <li>Here &lsquo;area&rsquo; means the area selected by doctors for their chamber or hospital
                            location and &lsquo;specialty&rsquo; means doctors&rsquo; own specialty.
                        </li>
                        <li>Only existing profile with facilities will show and No additional contents will be allowed
                            for this promotion.
                        </li>
                        <li>The promotion will be ended whenever the contract period is over.</li>
                    </ol>
                    <p>To confirm your Reach activation, please contact us over phone (01886555000) or mail us with
                        mentioning your &lsquo;name&rsquo; and &lsquo;phone number&rsquo;. We&rsquo;ll help you all the
                        way.</p>
                    <p><strong>Charge &amp; Payment: </strong></p>
                    <p>Monthly charges are varying on area to area. The standard charge for area category &lsquo;A&rsquo;
                        is BDT 2,000 /Month and area category &lsquo;B&rsquo; is BDT 1,500 / Month. Here area category
                        &lsquo;A&rsquo; means the popular areas for doctors practice e.g. &lsquo;Dhanmandi, Greenroad,
                        Panthopath&rsquo; in Dhaka and &lsquo;Panchlaish, GEC, OR Nizam road&rsquo; in Chattogram. All
                        other areas except &lsquo;A&rsquo; will be considered category &lsquo;B&rsquo;.</p>
                    <p>Interested practitioners need to follow the condition about the payment mentioned below:</p>
                    <ol>
                        <li>Make sure your payment is made successfully.</li>
                        <li>Make payment in favor of Bdcare- Bkash No. &ldquo;01819365396&rdquo;&nbsp;</li>
                        <li>Send your payment details e.g. last three digit of sender phone number over phone to
                            01886555000 or via <a href="mailto:bdcarepay@gmail.com">bdcarepay@gmail.com</a></li>
                    </ol>
                    <p><strong>Activation:</strong></p>
                    <p>Whenever the payment is made, your promotion will be activated.</p>
                    <p><em>Thank you for being with Bdcare.</em></p>
                    <p>&nbsp;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"/>

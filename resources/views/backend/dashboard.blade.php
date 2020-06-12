@include('frontend.header')

<!-- ###########################
    PROFILE SECTION
########################### -->

<section class="profile">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-xs-12 no-padding-right">
                <div class="profileLeft">
                    <h3>My Account</h3>

                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-xs-12 no-padding-left">
                <div class="profileRight">
                    <ul>
                        <li>
                            <div class="profileImg">

                                <?php if (Auth::User()->user_photo){?>

                                <img src="uploads/user_photo/{{Auth::User()->user_photo}}">

                                <?php }else{?>

                                <img src="{!! asset('uploads/user_photo/user_photo.png') !!}">
                                <?php } ?>

                            </div>
                        </li>
                        <li>
                            <h3>{{Auth::User()->user_name}}</h3>
                        </li>
                    </ul>
                    <h4>
                        <?php
                        if (Auth::User()->role_id == 3) {
                            $my_string = '';
                            $degrees = DB::table('doctors_degree_details')->select('degree_id')->where('doctor_id', Auth::User()->id)->get();
                            //print_r($degrees);
                            foreach ($degrees as $degree) {
                                $my_string .= DB::table('degrees')->where('id', $degree->degree_id)->first()->degree_name . " , ";
                            }
                            echo rtrim($my_string, ' ,');
                        }
                        ?>
                    </h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-xs-12 no-padding-right">
                @include('backend.menu')
            </div>

            <div class="col-lg-9 col-md-9 col-xs-12 no-padding-left">
                @include($body)
            </div>
        </div>
    </div>
</section>


@include('frontend.footer')

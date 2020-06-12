@include('frontend.header')

<!-- ###########################
    BANNER SECTION
########################### -->


<section class="healthCheckup">
    <div class="container" align="center">
        <h1>Appointment Booking</h1>
        <div class="row" >
            <div class="col-lg-1 col-md-1"></div>
            <div class="col-lg-10 col-md-10 col-xs-12">
                <?php foreach ($doctor_data as $row){ ?>
                <div class="checkupContent">
                    <div class="checkupTitle">

                        <h3 style="color: #002a80">{{ $row->doctor_name }}</h3>
                        <h4>Designation</h4>

                    </div>
                    <div class="checkupContentBox">
                        <h3>Experience: {{ $row->year_of_experience }} years</h3>
                        <h4>
                            <?php foreach ($speciality as $sp_row){?>
                                <span class="badge badge-pill badge-info">{{$sp_row->get_speciality ? $sp_row->get_speciality->speciality_name : ''}}</span>
                            <?php } ?>
                        </h4>
                    </div>
                    <div class="checkupBlankBox" style="height: auto" >
                        <br>
                        <?php foreach ($schedules as $sc_row){?>
                        <h5>{{$sc_row->get_hospital ? $sc_row->get_hospital->hospital_name : ''}} -- {{ $sc_row->day }}</h5>

                        <?php
                        for ($i=1;$i<=$loop_counter;$i++)
                        {
                        ?>
                        <a href="#" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">

                            <?php
                                if($i == 1)
                                    {
                                        echo $start_time = date("H:i", strtotime('+0 minutes', $start_time));
                                    }
                                else
                                    {
                                        echo $start_time = date("H:i", strtotime('+30 minutes', $start_time));
                                    }

                                $start_time = strtotime($start_time);
                            ?>
                        </a>
                        <?php
                        }
                        ?>

                        <?php } ?>
                        <br><br>
                    </div>
                    <div class="checkupPriceBox">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="priceBox">
                                        <h3>31% Off</h3>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="priceBox">
                                        <br>
                                        <h4>{{ $row->visiting_fees }}/-</h4>

                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <div class="priceBox" style="padding-top: 23px;">
                                        <a href="#">
                                            <h5>Book</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php } ?>
            </div>
        </div>
    </div>


</section>
<br>
<script>
    /*jQuery(document).ready(function () {
        Select2.init()
    });*/
</script>

@include('frontend.footer')

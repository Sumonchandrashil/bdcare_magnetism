
@if(session()->has('successMsg'))
    <div class="m-alert m-alert--outline alert alert-success alert-dismissible animated fadeIn" role="alert" style="margin-bottom: 0rem;" align="center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <span>{{ session()->get('successMsg') }}</span>
    </div>
@endif
@if(session()->has('errorMsg'))
    <div class="m-alert m-alert--outline alert alert-danger alert-dismissible animated fadeIn" role="alert" style="margin-bottom: 0rem;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <span>{{ session()->get('errorMsg') }}</span>
    </div>
@endif

<div class="profileContent">
    <h3>
        <i class="fas fa-file-medical"></i>
    </h3>
    <p style="font-weight: bold;font-size: 20px"><u>
        <?php
            if(Auth::user()->role_id == 3){
            $status = DB::table('doctors_datas')->where('created_by',Auth::user()->id)->first()->status;
            if($status == 0)
                {
                    echo "Sorry! Your Profile is not Active Yet Please Contact Admin";
                }
            elseif($status == 1){
                echo "Your Profile is Now Active";
            }
        ?>

        <?php } ?>
            </u> </p>
</div>

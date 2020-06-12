<div class="profileContent" style="padding: 50px">

<form action="{{ url('doctors_profile/store') }}" method="post" enctype="multipart/form-data">
    @csrf
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
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputAddress2">Name</label>
            <input type="text" class="form-control" id="inputAddress2" name="name" placeholder="Name" value="{{$doc_data->doctor_name}}" autocomplete="off">
        </div>
        <div class="form-group col-md-6">
            <label for="inputEmail4">Email</label>
            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Ex: admin@gmail.com" value="{{$doc_data->email}}">
        </div>
    </div>
    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="inputEmail6">Contact No</label>
            <input type="number" class="form-control" id="inputEmail6" name="emergency_contact" placeholder="Ex: 01712234567" value="{{$doc_data->emergency_contact}}">
        </div>

        <div class="form-group col-md-2">
            <label for="inputAddress8">Year Of Experience</label>
            <input type="number" class="form-control" id="inputAddress8" name="year_of_experience" placeholder="Ex: 5" value="{{$doc_data->year_of_experience}}">
        </div>

        <div class="form-group col-md-4">
            <label for="inputAddress10">Visiting Fees</label>
            <input type="text" class="form-control" id="inputAddress10" name="visiting_fees" placeholder="Ex: 500/1000 " value="{{$doc_data->visiting_fees}}">
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputCity">Address</label>
            <textarea type="text" class="form-control" id="inputCity" name="address" placeholder="Ex: Mirpur-10, Dhaka-1216" >{{$doc_data->address}}</textarea>
        </div>

        <div class="form-group col-md-2">
            <label for="inputState">Gender</label>
            <select name="gender" class="form-control" id="inputState">
                <option <?php if ($doc_data->gender=='M'){?> selected <?php } ?> > M</option>
                <option <?php if ($doc_data->gender=='F'){?> selected <?php } ?>>F</option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="designation">Degisnation</label>
            <input type="text" class="form-control" name="current_designation" id="designation" placeholder="Ex: Surgen, Professor, Senior Consultant " value="{{$doc_data->current_designation}}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="institute">Institute</label>
            <input type="text" id="institute" class="form-control" name="summary" placeholder="Ex: Where you work" value="{{$doc_data->summary}}">
        </div>
        <div class="form-group col-md-6">
            <label for="inputCity">BIO Data</label>
            <textarea type="text" class="form-control" id="bio_data" name="bio_data" >{{$doc_data->bio_data}}</textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="bmdc">BMDC Reg. No</label>
            <input type="number" class="form-control" id="bmdc" name="bmdc_reg_no" placeholder="BMDC Reg. No" value="{{$doc_data->bmdc_reg_no}}">
        </div>

        <div class="form-group col-md-3">
            <label for="bmdc2">BMDC Reg. Year</label>
            <input type="number" class="form-control" id="bmdc2" name="bmdc_reg_year" placeholder="BMDC Reg. Year" value="{{$doc_data->bmdc_reg_year}}">
        </div>

        <div class="form-group col-md-3">
            <label for="bmdc2">Age</label>
            <input type="number" class="form-control" id="age" name="age" placeholder="Enter your age.." value="{{$doc_data->age}}">
        </div>
    </div>



    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="img">Upload Image of BMDC Reg Card</label>
            <input type="file" id="img" class="form-control" name="bmdc_doc">
            <br>
            <div class="col-md-3"><?php
            if($doc_data->bmdc_doc)
                {
                    ?>
                <img src="uploads/doctor_bmdc_doc/{{$doc_data->bmdc_doc}}" class="img img-responsive" width="150px">
                <?php
                }
            ?></div>
        </div>

        <div class="form-group col-md-6">
            <label for="img2">Upload Image of Passport/Nid</label>
            <input type="file" id="img2" class="form-control" name="passport_nid">
            <br>
            <div class="col-md-3"><?php
                if($doc_data->passport_nid)
                {
                ?>
                <img src="uploads/doctor_passport_nid/{{$doc_data->passport_nid}}" class="img img-responsive" width="150px">
                <?php
                }
                ?> </div>

        </div>

    </div>



    <button type="submit" class="btn btn-primary">Save</button>
</form>
</div>

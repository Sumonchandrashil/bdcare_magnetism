<div class="profileContent" style="padding: 50px">

<form action="{{ url('patient_profile/store') }}" method="post" enctype="multipart/form-data">
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
            <input type="text" class="form-control" name="name" placeholder="Ex ABC" value="{{$patient_data->patient_name}}">
        </div>
        <div class="form-group col-md-6">
            <label for="inputEmail4">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Ex: admin@gmail.com" value="{{$patient_data->email}}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputEmail4">Occupation</label>
            <input type="text" class="form-control" name="occupation" placeholder="Ex: Nurse, Software Engineer" value="{{$patient_data->occupation}}">
        </div>
        <div class="form-group col-md-6">
            <label for="inputEmail4">Contact No</label>
            <input type="number" class="form-control" name="contact" placeholder="01712234567" value="{{$patient_data->contact}}">
        </div>
    </div>

    <div class="form-group">

    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputCity">Age *</label>
            <input type="number" class="form-control" name="age" placeholder="Ex: 30" value="{{$patient_data->age}}">
        </div>
        <div class="form-group col-md-6">
            <label for="inputState">Gender</label>
            <select name="gender" class="form-control">
                <option <?php if ($patient_data->gender=='M'){?> selected <?php } ?> > M</option>
                <option <?php if ($patient_data->gender=='F'){?> selected <?php } ?>>F</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputCity">Address</label>
            <textarea type="text" class="form-control" name="address" placeholder="Mirpur-10, Dhaka-1216" >{{$patient_data->address}}</textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="inputCity">Details</label>
            <textarea type="text" class="form-control" name="details" placeholder="Any important Details that you want to share" >{{$patient_data->details}}</textarea>
        </div>

    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
</div>

<div class="profileContent" style="padding: 50px">
    <div class="container">
        <hr style="margin:5px 0 5px 0;">
        <div class="row">
            <div class="col-md-6 font-weight-bold">Name :</div>
            <div class="col-md-6">{{ $doc_data_info->doctor_name?$doc_data_info->doctor_name:'' }}</div>
        </div>
        <div class="clearfix"></div>
        <div style="border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0"></div>
        <div class="row">
            <div class="col-md-6 font-weight-bold">Email :</div>
            <div class="col-md-6">{{ $doc_data_info->email?$doc_data_info->email:'' }} </div>
        </div>
        <div class="clearfix"></div>
        <div style="border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0"></div>

        <div class="row">
            <div class="col-md-6 font-weight-bold">Degree Name :</div>
            <div class="col-md-6">
                @foreach($doc_data_info->get_degree as $key=>$degree)
                    {{ $degree->get_degree->degree_name?$degree->get_degree->degree_name:'' }}<br>
                @endforeach
            </div>
        </div>
        <div class="clearfix"></div>
        <div style="border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0"></div>

        <div class="row">
            <div class="col-md-6 font-weight-bold">Speciality :</div>
            <div class="col-md-6">
                @foreach($doc_data_info->get_speciality as $key=>$speciality)
                    {{++$key}}. {{ $speciality->get_speciality ? $speciality->get_speciality->speciality_name : '' }}
                    <br>
                @endforeach
            </div>
        </div>
        <div class="clearfix"></div>
        <div style="border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0"></div>

        <div class="row">
            <div class="col-md-6 font-weight-bold">Contact No :</div>
            <div class="col-md-6">{{ $doc_data_info->emergency_contact?$doc_data_info->emergency_contact:'' }}</div>
        </div>
        <div class="clearfix"></div>
        <div style="border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0"></div>

        <div class="row">
            <div class="col-md-6 font-weight-bold">Year Of Experience :</div>
            <div class="col-md-6">{{ $doc_data_info->year_of_experience?$doc_data_info->year_of_experience:'' }}</div>
        </div>
        <div class="clearfix"></div>
        <div style="border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0"></div>

        <div class="row">
            <div class="col-md-6 font-weight-bold">Designation :</div>
            <div class="col-md-6">{{ $doc_data_info->current_designation?$doc_data_info->current_designation:'' }}</div>
        </div>

        <div class="clearfix"></div>
        <div style="border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0"></div>

        <div class="row">
            <div class="col-md-6 font-weight-bold">Institute :</div>
            <div class="col-md-6">

                @foreach($doc_data_info->get_degree as $key=>$institute)
                    {{ $institute->institute?$institute->institute:'' }}<br>
                @endforeach
            </div>
        </div>
        <div class="clearfix"></div>
        <div style="border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0"></div>

        <div class="row">
            <div class="col-md-6 font-weight-bold">BMDC Reg. No :</div>
            <div class="col-md-6">{{ $doc_data_info->bmdc_reg_no?$doc_data_info->bmdc_reg_no:'' }}</div>
        </div>
        <div class="clearfix"></div>
        <div style="border-bottom:1px #f8f8f8 solid;  margin:5px 0  5px 0"></div>

        <div class="row">
            <div class="col-md-6 font-weight-bold">BMDC Reg. Year :</div>
            <div class="col-md-6">{{ $doc_data_info->bmdc_reg_year?$doc_data_info->bmdc_reg_year:'' }}</div>
        </div>

    </div>
</div>

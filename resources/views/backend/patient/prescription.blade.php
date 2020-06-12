<!DOCTYPE html>
<html lang="en">
<head>
    <title>Prescription</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>
        /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
        .row.content {height: 1500px}

        /* Set gray background color and 100% height */
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {height: auto;}
        }
    </style>
</head>
<script>
    function PrintElem(elem)
    {
        var mywindow = window.open('', 'PRINT', 'height=400,width=1600');

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1>' + document.title  + '</h1>');
        mywindow.document.write(document.getElementById(elem).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>
<body id="print">
<div class="container-fluid" >
    <div class="row content" >
        <div class="col-sm-2 sidenav" align="center">

            <b>Patient </b>
            <hr>

            <h4 ><?php print_r($prescription->get_patient->patient_name);?></h4>
            <h5 style="border-bottom: 1px solid black"></h5>
            <!--<h4><b>Gender:</b> <?php print_r($prescription->get_patient->gender);?></h4>
            <h5><b>Email:</b> <?php print_r($prescription->get_patient->email);?></h5>
            <h5><b>Phone:</b> <?php print_r($prescription->get_patient->contact);?></h5>-->
            <hr style="color: black"><hr>
            <h4>History</h4>
            <br>
            <p>{{ $prescription->history }}</p>

            <hr>
            <h4>Detail</h4>
            <p>{{ $prescription->description }}</p>

            <hr>
            <h4>Test Suggestion</h4>
            <p>{{ $prescription->tests }}</p>

            <hr>
            <h4>Advice</h4>
            <p>{{ $prescription->recommendation }}</p>
        </div>

        <div class="col-sm-10">
            <div class="row">

                <div class="col-sm-3 col-sm-offset-9" style="text-align: justify">

                        <h4 align="center"><b> <?php print_r($prescription->get_doctor->doctor_name);?></b></h4>
                        <h5 align="center"> <?php
                                                $degree_id = DB::table('doctors_degree_details')->where('doctor_id',$prescription->get_doctor->created_by)->get();
                                                foreach ($degree_id as $row)
                                                    {
                                                        echo DB::table('degrees')->where('id',$row->degree_id)->first()->degree_name.'<b>, </b>';
                                                    }
                                                ?>
                        </h5>
                        <h5 align="center"> <?php print_r($prescription->get_doctor->current_designation);?> </h5>
                        <h5 align="center"> <?php print_r($prescription->get_doctor->summary);?> </h5>

                        <!--<h5><b>Email:</b> <?php print_r($prescription->get_doctor->email);?></h5>
                        <h5><b>Phone:</b> <?php print_r($prescription->get_doctor->emergency_contact);?></h5>-->
                </div>
            </div>

            <hr>

            <h4>Medication</h4>
            <p>
            <table class="table table-responsive">
                <thead>
                    <th>Sl</th>
                    <th>Medicine Type</th>
                    <th>Medicine Name</th>
                    <th>Doze</th>
                </thead>
                <?php
                    $sl=1;
                    $pres_data = json_decode($prescription->diagonosis);
                    /*print_r($pres_data);
                    exit();*/
                    foreach ($pres_data as $row_data)
                        {
                        ?>
                        <tr>
                            <td><?=$sl++;?></td>
                            <td><?=$row_data->medicineType;?></td>
                            <td><?=$row_data->medicineName;?></td>
                            <td>
                                <?=$row_data->dose;?>

                                <?php

                                    if($row_data->isBeforeMeal == "true")
                                    {
                                        echo "Before Meal";
                                    }
                                    else
                                    {
                                        echo "After Meal";
                                    }
                                ?>
                            </td>
                        </tr>
                <?php
                        }
                ?>
            </table>
            </p>

            <hr>

        </div>



        <div align="center" style="color: #6b6f81">
            This online prescription is provided by mentioned doctor.
            <br>
            The Prescription also considered as signed by him/her
        </div>

        <hr>
        <div align="center">
            <?php if(Auth::user()->role_id == 3){?>
            <a class="btn btn-primary" href="{{url('appointment-booked')}}">Back go List</a>
            <?php }elseif(Auth::user()->role_id == 4){ ?>
            <a class="btn btn-primary" href="{{url('appointment-booking')}}">Back go List</a>
            <?php } ?>
                <hr>
                <button onclick="PrintElem('print')" class="btn btn-success btn-sm">Print this page</button>
        </div>

    </div>
</div>

</body>
</html>

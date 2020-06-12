<html>
   <head>
      <style>
         body {font-family: sans-serif;
         font-size: 10pt;
         }
         p { margin: 0pt; }
         table.items {
         border: 0.1mm solid #000000;
         }
         td { vertical-align: top; }
         .items td {
         border-left: 0.1mm solid #000000;
         border-right: 0.1mm solid #000000;
         }
         table thead td { background-color: #EEEEEE;
         text-align: center;
         border: 0.1mm solid #000000;
         font-variant: small-caps;
         }
         .items td.blanktotal {
         background-color: #EEEEEE;
         border: 0.1mm solid #000000;
         background-color: #FFFFFF;
         border: 0mm none #000000;
         border-top: 0.1mm solid #000000;
         border-right: 0.1mm solid #000000;
         }
         .items td.totals {
         text-align: right;
         border: 0.1mm solid #000000;
         }
         .items td.cost {
         text-align: "." center;
         }
      </style>
   </head>
   <body>
      <!--mpdf
         <htmlpageheader name="myheader">
            <table width="100%" style="font-size: 10pt;">
               <tr>
                  <td width="40%">
                     <div style="text-align: left; padding-top: 3mm; ">
                        <h3 style="padding-top: 3mm;">Patient</h3>
                        <p>{{ $prescription->get_patient->patient_name }}</p>
                        <p>Age: {{ $prescription->get_patient->age }} Year's </p>
                        <p>{{ $prescription->get_patient->gender }} </p>
                        <p>{{ $prescription->get_patient->email }} </p>
                        <p>{{ $prescription->get_patient->contact }} </p>
                        <br>
                        <p>Date : {{ date('d M, Y', strtotime($prescription->created_at)) }} </p>
                     </div>                     
                  </td>
                  <td width="60%" style="text-align: center;">
                     <h4 style="font-weight: bold; font-size: 15pt;">
                        {{ $prescription->get_doctor->doctor_name }}
                     </h4>
                     @foreach($degrees as $key => $degree)
                        {{ $degree->degree_name }} @if(! $loop->last), @endif 
                     @endforeach
                     <br />
                     {{ $prescription->get_doctor->current_designation }}<br />
                     {{ $prescription->get_doctor->summary }}<br />
                     {{ $prescription->get_doctor->email }}<br />
                     {{--{{ $prescription->get_doctor->emergency_contact }}--}}
                  </td>
               </tr>
            </table>
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">

            </div>            
         </htmlpageheader>
         <htmlpagefooter name="myfooter">
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm;font-style: italic; ">
               This online prescription is provided by mentioned doctor.
               <br>
               The Prescription also considered as signed by him/her.
            </div>
         </htmlpagefooter>
         <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
         <sethtmlpagefooter name="myfooter" value="on" />
         mpdf-->

      <table width="100%" style="font-family: serif;" cellpadding="10">
         <tr>
            <td width="30%" style="background-color: #f1f1f1;">
               <h5 style="font-size: 9pt; color: #555555; font-family: sans;font-style: italic;">History</h5>
               <p>{{ $prescription->history }}</p>
               <br /><br />

               <h5 style="font-size: 9pt; color: #555555; font-family: sans;font-style: italic;">Detail</h5>
               <p>{{ $prescription->description }}</p>
               <br /><br />

               <h5 style="font-size: 9pt; color: #555555; font-family: sans;font-style: italic;">Test Suggestion</h5>
               <p>{{ $prescription->tests }}</p>
               <br /><br />

               <h5 style="font-size: 9pt; color: #555555; font-family: sans;font-style: italic;">Advice</h5>
               <p>{{ $prescription->recommendation }}</p> 
               <br /><br />
            </td>

            <td width="5%">&nbsp;</td>

            <td width="65%" style="">
               <h5 style="font-size: 9pt; color: #555555; font-family: sans;font-style: italic;">Medication</h5>
               <br>
               <table width="90%">
                   <thead>
                       <th>Sl</th>
                       <th>Medicine Type</th>
                       <th>Medicine Name</th>
                       <th>Doze</th>
                       <th>Before/After Meal</th>
                   </thead>
                   @php
                       $sl=1;
                       $pres_data = json_decode($prescription->diagonosis);
                     @endphp
                       @foreach ($pres_data as $row_data)
                           {
                           ?>
                           <tr>
                               <td>{{ $sl++ }}.</td>
                               <td>{{ $row_data->medicineType ? $row_data->medicineType : 'Not Found' }}</td>
                               <td>{{ $row_data->medicineName ? $row_data->medicineName : 'Not Found' }}</td>
                               <td>
                                   {{$row_data->dose}}
                               </td>
                               <td style="font-size: 10.5px;font-style: italic;font-weight: bold;color: #6b6f81">
                                   @if($row_data->isBeforeMeal == "true")
                                        Before Meal
                                   @else
                                       After Meal
                                   @endif
                               </td>
                           </tr>
                   @endforeach
               </table>               
            </td>
         </tr>
      </table>     

   </body>
</html>

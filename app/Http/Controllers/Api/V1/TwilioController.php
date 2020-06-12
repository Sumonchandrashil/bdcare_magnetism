<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;

use JWTFactory;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

use Validator;
use Response;

use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

use DateTime;
use DateTimeZone;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

use App\Model\BDCare\DoctorsData;

class TwilioController extends Controller
{
    protected $sid;
    protected $token;
    protected $key;
    protected $secret;

    public function __construct()
    {
        $this->sid = config('services.twilio.sid');
        $this->token = config('services.twilio.token');
        $this->key = config('services.twilio.key');
        $this->secret = config('services.twilio.secret');
    }

    public function createRoom(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required',
        ]);

        if ($validator->fails()) {

            $data['status'] = false;
            $data['message'] = 'doctor_id field is required';
            return response()->json($data);
        }

        try{

            $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
            $date = $date->format('Y-m-d H:i:s');

            $client = new Client($this->sid, $this->token);
            $exists = $client->video->rooms->read([ 'uniqueName' => $request->doctor_id]);

            if (empty($exists)) {

                $client->video->rooms->create([
                    'uniqueName' => $request->doctor_id,
                    'type' => 'group',
                    'recordParticipantsOnConnect' => false
                ]);
            }
            $data['status'] = true;
            $data['message'] = "Success";
            $data['room_name'] = $request->doctor_id;

                    //Trigger FCM Notice to doctor
                    $optionBuilder = new OptionsBuilder();
                    $optionBuilder->setTimeToLive(1*1) //$optionBuilder->setTimeToLive(60*20);
                                ->setCollapseKey('a_collapse_key');

                    $notificationBuilder = new PayloadNotificationBuilder('Video call requested');
                    $notificationBuilder->setBody('A patient is waiting for you.')
                                        ->setSound('default');

                    $dataBuilder = new PayloadDataBuilder();
                    $dataBuilder->addData([
                                            'bdcare' => 'video',
                                            'room' => $request->doctor_id,
                                            'caller_user_id' => Auth::user()->id, //toNotify if call rejected
                                            'patient_name' => Auth::user()->user_name ? Auth::user()->user_name : 'Unknown',
                                            'patient_photo' => Auth::user()->user_photo ? Auth::user()->user_photo : 'user_photo.png',
                                        ]);

                    $option = $optionBuilder->build();
                    $notification = $notificationBuilder->build();
                    $noticeData = $dataBuilder->build();

                    $doctor = DoctorsData::findOrFail($request->doctor_id);

                    if($doctor && $doctor->get_user->token){

                        $token = $doctor->get_user->token; // "a_registration_from_your_database";
                        $downstreamResponse = FCM::sendTo($token, $option, null, $noticeData); //FCM::sendTo($token, $option, $notification, $noticeData);

                        $responseCount = $downstreamResponse->numberSuccess();
                        if ($responseCount > 0) {
                            
                            DB::table('twilio_logs')->insert(
                                [
                                    'type' => 'FCM Notice was sent to doctor - success',
                                    'posted_data' => 'Docor FCM token is valid and sent call notice.',
                                    'created_at' => $date,
                                ]
                            );
                        } else {

                            throw new \Exception("Docor FCM token is not valid.");
                        }

                    } else {

                        DB::table('twilio_logs')->insert(
                            [
                                'type' => 'FCM Notice was sent to doctor - failed',
                                'posted_data' => 'Docor FCM token is not available.',
                                'created_at' => $date,
                            ]
                        );

                        throw new \Exception("Docor FCM token is not available.");
                    }

        }
        catch (\Exception $e)
        {
            $data['status'] = false;
            $data['message'] = "Failed";
            $data['error_msg'] = $e->getMessage();
            $data['room_name'] = null;
        }

        return response()->json($data);  
    }

    public function joinRoom(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required',
        ]);

        if ($validator->fails()) {

            $data['status'] = false;
            $data['message'] = 'doctor_id field is required';
            return response()->json($data);
        }

        try{
            $room_name = $request->doctor_id;
            
            $identity = Auth::user()->id;
            $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);

            $videoGrant = new VideoGrant();
            $videoGrant->setRoom($room_name);

            $token->addGrant($videoGrant);

            $data['status'] = "success";
            $data['msg'] = "joined successfuly.";
            $data['accessToken'] = $token->toJWT();
            $data['identity'] = $identity;
            $data['room_name'] = $room_name;

            // $this->sendTwilioNotification($identity);

        }
        catch (\Exception $e)
        {
            $data['status'] = false;
            $data['message'] = "Failed";
            $data['error_msg'] = $e->getMessage();
            $data['room_name'] = null;
        }

        return response()->json($data); 
    }

    public function rejectRoom(Request $request) {

        $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date = $date->format('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
            'room_name' => 'required',
            'caller_user_id' => 'required',
        ]);

        if ($validator->fails()) {

            $data['status'] = false;
            $data['message'] = 'room_name or caller_user_id field is missing!';
            return response()->json($data);
        }


        try{

            //Trigger FCM Notice to caller
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(1*1) //$optionBuilder->setTimeToLive(60*20);
                        ->setCollapseKey('a_collapse_key');

            $notificationBuilder = new PayloadNotificationBuilder('Video call rejected');
            $notificationBuilder->setBody('A patient call was rejected.')
                                ->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData([
                                    'bdcare' => 'call_reject',
                                    'room_name' => $request->room_name ? $request->room_name : 'null'
                                ]);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $noticeData = $dataBuilder->build();

            $user = User::findOrFail($request->caller_user_id);

            if($user && $user->token){

                $token = $user->token; // "a_registration_from_your_database";
                $downstreamResponse = FCM::sendTo($token, $option, null, $noticeData);

                $responseCount = $downstreamResponse->numberSuccess();
                if ($responseCount > 0) {
                    
                    DB::table('twilio_logs')->insert(
                        [
                            'type' => 'FCM call was rejected - success',
                            'posted_data' => 'Room: '.$request->room_name.' Caller User ID : '.$request->caller_user_id.'',
                            'created_at' => $date,
                        ]
                    );

                    $data['status'] = true;
                    $data['message'] = 'Call reject notification was sent!';
                    return response()->json($data);

                } else {

                    throw new \Exception("FCM token is not valid!");
                }

            } else {

                throw new \Exception("FCM token is not available!");
            }

            throw new \Exception("Something went wrong!");
        }
        catch (\Exception $e)
        {
            $data['status'] = false;
            $data['message'] = "Failed";
            // $data['error_msg'] = $e->getMessage();

            return response()->json($data);
        }
    }

    //Cross platform twilio notification
    public function sendTwilioNotification($identity){

        $twilio = new Client($this->sid, $this->token);

        $notification = $twilio->notify->v1->services("IS5798d9fdc6f2d8794fe4e426dd8b8c87")
                                           ->notifications
                                           ->create(array(
                                                        "body" => "Hello Raju - msg from sendTwilioNotification method",
                                                        "identity" => array($identity)
                                                    )
                                           );

        // print($notification->sid);

        $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $date = $date->format('Y-m-d H:i:s');

        $notification = (string) $notification;

        DB::table('twilio_logs')->insert(
            [
                'type' => 'sendTwilioNotification',
                'posted_data' => $notification,
                'created_at' => $date,
            ]
        );                                           

    }
}

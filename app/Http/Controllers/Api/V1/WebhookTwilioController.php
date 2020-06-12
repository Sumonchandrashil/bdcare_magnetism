<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
// use JWTFactory;
// use JWTAuth;
use Validator;
use Response;

use DateTime;
use DateTimeZone;

use App\Model\Twilio\TwilioVideo;
use App\Model\Twilio\TwilioVideoLog;

class WebhookTwilioController extends Controller
{
    public function videoRespond(Request $request)
    {           
        if($_POST) {
            \Log::debug("videoResponded : ");

            $content = '';
            foreach ($_POST as $key => $value) {
                $content .= htmlspecialchars($key)." => ".htmlspecialchars($value).", ";
            }

            $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
            $date = $date->format('Y-m-d H:i:s');

            DB::table('twilio_logs')->insert(
                [
                    'posted_data' => $content,
                    'created_at' => $date,
                ]
            );
            
        } else {
            \Log::debug("not a callback hit: ");
        }

        //Video Call Reportings
        if ($request->filled('RoomSid')) {

            $video = TwilioVideo::firstOrCreate(['RoomSid' => $request->RoomSid]);

            if ($request->filled('RoomStatus')) {
                $video->RoomStatus = $request->RoomStatus;
            }
            if (is_null($video->RoomName)) {
                $video->RoomName = $request->RoomName;
            }            

            if ( (is_null($video->callerUserId) || $video->callerUserId==0 ) && $request->filled('ParticipantIdentity')) {
                $video->callerUserId = $request->ParticipantIdentity;
            }
            if ($request->filled('ParticipantIdentity')) {
                
                if ($video->callerUserId != $request->ParticipantIdentity) {
                    $video->recipientUserId = $request->ParticipantIdentity;
                }                
            }

            if (is_null($video->AccountSid)) {
                $video->AccountSid = $request->AccountSid;
            }
            if ($request->filled('RoomDuration')) {
                $video->RoomDuration = $request->RoomDuration;
            }

            $video->save();   

            if ($request->SequenceNumber > 0 && $request->RoomStatus != 'completed') {
                $log = new TwilioVideoLog;
                $log->twilio_video_id = $video->id;
                $log->SequenceNumber = $request->SequenceNumber;
                $log->ParticipantStatus = $request->ParticipantStatus;
                $log->ParticipantIdentity = $request->ParticipantIdentity;
                $log->StatusCallbackEvent = $request->StatusCallbackEvent;
                $log->TrackKind = $request->TrackKind;
                $log->ParticipantDuration = $request->ParticipantDuration;
                $log->RawData = print_r($request->all(), true);
                $log->save();
            }
        }       
    }

}
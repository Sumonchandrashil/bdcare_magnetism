<?php

namespace App\Http\Controllers\BDCare;

use App\Http\Controllers\Controller;
use App\Model\Twilio\TwilioVideo;
use App\Model\Twilio\TwilioVideoLog;
use DB;
use Exception;
use Illuminate\Http\Request;

class VideoCallingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $videoCallingList = TwilioVideo::leftJoin('users as u1', function ($join) {
                $join->on('u1.id', '=', 'twilio_videos.RoomName');
                $join->on('u1.id', '!=', DB::raw("''"));
            })
                ->leftJoin('users as u2', function ($join) {
                    $join->on('u2.id', '=', 'twilio_videos.callerUserId');
                    $join->on('u2.id', '!=', DB::raw("''"));
                })
                ->leftJoin('users as u3', function ($join) {
                    $join->on('u3.id', '=', 'twilio_videos.recipientUserId');
                    $join->on('u3.id', '!=', DB::raw("''"));
                })
                ->select([
                    'twilio_videos.id',
                    'twilio_videos.RoomName',
                    'twilio_videos.callerUserId',
                    'twilio_videos.recipientUserId',
                    'twilio_videos.RoomStatus',
                    'u1.user_name as room_name',
                    'u2.user_name as caller_name',
                    'u3.user_name as recipient_name',
                    'twilio_videos.RoomDuration',
                ]);

            return datatables()->of($videoCallingList)->toJson();
        }

        return view('bdcare.video_calling');
    }

    public function show($id)
    {
        try {
            $editModeData = TwilioVideoLog::where('twilio_video_id', '=', $id)
                ->leftJoin('users', function ($join) {
                    $join->on('users.id', '=', 'twilio_video_logs.ParticipantIdentity');
                    $join->on('users.id', '!=', DB::raw("''"));
                })
                ->select([
                    'twilio_video_logs.id',
                    'users.user_name as ParticipantName',
                    'twilio_video_logs.twilio_video_id',
                    'twilio_video_logs.SequenceNumber',
                    'twilio_video_logs.ParticipantStatus',
                    'twilio_video_logs.ParticipantIdentity',
                    'twilio_video_logs.StatusCallbackEvent',
                    'twilio_video_logs.TrackKind',
                    'twilio_video_logs.ParticipantDuration',
                    'twilio_video_logs.RawData'
                ])
                ->get();
            $data = [
                'details' => $editModeData
            ];
            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'data' => []]);
        }
    }
}

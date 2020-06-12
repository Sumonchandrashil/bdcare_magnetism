<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class PushNotificationController extends Controller
{
    public function notice() {

    	// .env
		// FCM_SERVER_KEY=AAAAegA1Hec:APA91bFVAx_1oX0grhLOQ1COSmgxplbIvBea1CkpMq_dJWaej5ZwhfkwHlm1Xfece9EHRzndLRNjkTNMSjS9-wFLE-tI9TPKmdhojuXCCZfWqNgQXZk8eGWZLkND2xDwiRhfXyuKHsrU
		// FCM_SENDER_ID=523989491175

		$optionBuilder = new OptionsBuilder();
		// $optionBuilder->setTimeToLive(60*20);
		$optionBuilder->setTimeToLive(1*1);

		$notificationBuilder = new PayloadNotificationBuilder('AAKheri test - from TRK');
		$notificationBuilder->setBody('AAKheri test - from TRK')
						    ->setSound('default');

		$dataBuilder = new PayloadDataBuilder();
		$dataBuilder->addData(['a_data' => 'my_data']);

		$option = $optionBuilder->build();
		$notification = $notificationBuilder->build();
		$data = $dataBuilder->build();

		// $token = "a_registration_from_your_database";
		$token = "frb8CyH7ckI:APA91bEOR4szJbM4dTMR13CgZTSko1kwwZnL6svCqm6tnJXqUefAkvy9BcPcvUeVTqJLSxo8Dun7xMmQOtb1vVq4W2sM6K8T8CE5d4YzV5wqwfQBWQF722fGPW4JM1CODBM42SnlXyRI";

		$downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
		
		print_r( $downstreamResponse->numberSuccess() );

    }
    public function url() {
    	echo "yes url";
    }

    function fcmNotice(Request $request){

            //Trigger FCM Notice to doctor for VIDEO Calling Testing
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(1*1) //$optionBuilder->setTimeToLive(60*20);
                        ->setCollapseKey('a_collapse_key');

            $notificationBuilder = new PayloadNotificationBuilder('WebFCM - Video call requested');
            $notificationBuilder->setBody('WebFCM - A patient is waiting for you.')
                                ->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData([
                                    'bdcare' => 'true',
                                    'body' => 'WebFCM - Body of Your Notification in Data',
                                    'title' => 'WebFCM - Title of Your Notification in Title',
                                    'room' => 'fcm web',
                                    'identity' => 'WebFCM',
                                    'access_token' => 'WebFCM',
                                ]);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $noticeData = $dataBuilder->build();

                $token = $request->fcm_token;
                $downstreamResponse = FCM::sendTo($token, $option, null, $noticeData);
                // $downstreamResponse->numberSuccess();

                dd($downstreamResponse);
    }

    function fcmPushNotice(Request $request){

            //Trigger FCM Notice to Testing           

            $title = 'fcmPushNotice';
            $msg = 'fcmPushNotice';
            $token = $request->fcm_token;

            push_notification($title,$msg,$token);

        dd('End of the line.');                 
    }
}

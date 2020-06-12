<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => true,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAegA1Hec:APA91bFVAx_1oX0grhLOQ1COSmgxplbIvBea1CkpMq_dJWaej5ZwhfkwHlm1Xfece9EHRzndLRNjkTNMSjS9-wFLE-tI9TPKmdhojuXCCZfWqNgQXZk8eGWZLkND2xDwiRhfXyuKHsrU'),
        'sender_id' => env('FCM_SENDER_ID', '523989491175'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];

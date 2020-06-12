<?php

use Illuminate\Support\Facades\DB;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM as Fcm2;

use DateTime as DateTime2;
use DateTimeZone as DateTimeZone2;

function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

function dateConvertFormtoDB($date){
    if(!empty($date)){
        return date("Y-m-d",strtotime(str_replace('/','-',$date)));
    }
}

function dateConvertDBtoForm($date){
    if(!empty($date)){
        $date = strtotime($date);
        return date('d/m/Y', $date);
    }
}

function permissionCheck(){

    $role_id = session('logged_session_data.role_id');
    return $result =  array_column(json_decode(DB::table('acl_menus')->select('menu_url')
        ->join('acl_menu_permissions', 'acl_menu_permissions.menu_id', '=', 'acl_menus.id')
        ->where('acl_menu_permissions.role_id', '=', $role_id)
        ->where('menu_url', '!=',null)
        ->get()->toJson(),true),'menu_url');
    //->whereNotNull('action')->get()->toJson(),true);
}

/*function permissionMenu(){

    return $permission_menu = array_column(json_decode(Menu::join('acl_menu_permissions', 'acl_menu_permission.menu_id', '=', 'acl_menus.id')
    ->where('role_id', Auth::user()->role_id)
    ->where('menu_url', '!=',null)
    ->get()->toJson(), true),'menu_url');

}*/
function showMenu(){
    $role_id = session('logged_session_data.role_id');
    $modules = json_decode(DB::table('acl_modules')->get()->toJson(), true);

    $menus =  json_decode(DB::table('acl_menus')
        ->select(DB::raw('acl_menus.id, acl_menus.menu_name, acl_menus.menu_url, acl_menus.parent_id, acl_menus.module_id'))
        ->join('acl_menu_permissions', 'acl_menu_permissions.menu_id', '=', 'acl_menus.id')
        ->where('acl_menu_permissions.role_id',$role_id)
        ->where('acl_menus.status',1)
        ->whereNull('action')
        ->orderBy('acl_menus.id','ASC')
        ->get()->toJson(),true);




    $sideMenu = [];
    if($menus){
        foreach ($menus as $menu){

            if(!isset($sideMenu[$menu['module_id']])){
                $moduleId = array_search($menu['module_id'], array_column($modules, 'id'));

                $sideMenu[$menu['module_id']] = [];
                $sideMenu[$menu['module_id']]['id'] = $modules[$moduleId]['id'];
                $sideMenu[$menu['module_id']]['module_name'] = $modules[$moduleId]['module_name'];
                $sideMenu[$menu['module_id']]['icon_class'] = $modules[$moduleId]['icon_class'];
                $sideMenu[$menu['module_id']]['menu_url'] = '#';
                $sideMenu[$menu['module_id']]['parent_id'] = '';
                $sideMenu[$menu['module_id']]['module_id'] = $modules[$moduleId]['id'];
                $sideMenu[$menu['module_id']]['sub_menu'] = [];
            }
            if($menu['parent_id'] == 0){
                $sideMenu[$menu['module_id']]['sub_menu'][$menu['id']] = $menu;
                $sideMenu[$menu['module_id']]['sub_menu'][$menu['id']]['sub_menu'] = [];
            }else{

                array_push($sideMenu[$menu['module_id']]['sub_menu'][$menu['parent_id']]['sub_menu'], $menu);
            }

        }
    }

    return $sideMenu;
}


function getCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');

    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }

    $tks = implode('', array_reverse($str));
    $paise = '';

    if ($decimal) {
        $paise = 'and ';
        $decimal_length = strlen($decimal);

        if ($decimal_length == 2) {
            if ($decimal >= 20) {
                $dc = $decimal % 10;
                $td = $decimal - $dc;
                $ps = ($dc == 0) ? '' : '-' . $words[$dc];

                $paise .= $words[$td] . $ps;
            } else {
                $paise .= $words[$decimal];
            }
        } else {
            $paise .= $words[$decimal % 10];
        }

        $paise .= ' Paisa';
    }

    return ($tks ? $tks . 'Taka ' : '') . $paise ;
}

function appointment_schedule()
{
    $appointment_schedule_time = DB::table('setup')->where('id',1)->first();

    if($appointment_schedule_time)
    {
        $appointment_schedule_time = $appointment_schedule_time->value;
    }
    else{
        $appointment_schedule_time = 0;
    }

    return $appointment_schedule_time;
}

function push_notification($title,$msg,$token)
{
/*    
    $optionBuilder = new OptionsBuilder();
    //$optionBuilder->setTimeToLive(60*20);

    $notificationBuilder = new PayloadNotificationBuilder("$title");
    $notificationBuilder->setBody("$msg")
        ->setSound('default');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData(['a_data' => 'my_data']);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    FCM::sendTo($token, $option, $notification, $data);
*/

        $date = new DateTime2('now', new DateTimeZone2('Asia/Dhaka'));
        $date = $date->format('Y-m-d H:i:s');

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(1*1);

        $notificationBuilder = new PayloadNotificationBuilder("$title");
        $notificationBuilder->setBody("$msg")
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
                                'bdcare' => 'app',
                                'messageBody' => $msg,
                                'messageTitle' => $title,
                                'notificationId' => -1,
                                'roleId' => -1,
                                'isLoggedIn' => true,
                            ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $noticeData = $dataBuilder->build();

        $downstreamResponse = Fcm2::sendTo($token, $option, $notification, $noticeData);
        // return $downstreamResponse->numberSuccess(); 

            $responseCount = $downstreamResponse->numberSuccess();
            if ($responseCount > 0) {
                
                DB::table('twilio_logs')->insert(
                    [
                        'type' => 'App push notification - success',
                        'posted_data' => "Title: $title, Msg: $msg, FcmToken: $token",
                        'created_at' => $date,
                    ]
                );
            } else {

                DB::table('twilio_logs')->insert(
                    [
                        'type' => 'App push notification - failed',
                        'posted_data' => "Title: $title, Msg: $msg, FcmToken: $token",
                        'created_at' => $date,
                    ]
                );
            }          
}

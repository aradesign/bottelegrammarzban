<?php
include('config.php');
include('botapi.php');
include('apipanel.php');
include('jdf.php');
define('API_KEY', $token);
#-----------------------------#
$update = json_decode(file_get_contents("php://input"), true);
if (isset($update["message"])) {
    $from_id = $update["message"]["from"]["id"];
    $chat_id = $update["message"]["chat"]["id"];
  $Channel_status = $update["message"]["chat"]["type"];
  $text = $update["message"]["text"];
  $first_name = $update["message"]["from"]["first_name"];
} elseif (isset($update["callback_query"])) {
  $chat_id = $update["callback_query"]["message"]["chat"]["id"];
  $data = $update["callback_query"]["data"];
  $query_id = $update["callback_query"]["id"];
  $message_id = $update["callback_query"]["message"]["message_id"];
  $in_text = $update["callback_query"]["message"]["text"];
  $from_id = $update["callback_query"]["from"]["id"];
}
#-----------------------#
if(!is_dir("data")){
    mkdir("data");
}
if (!file_exists("data/value")){
    file_put_contents('data/value',"1");
}
#-----------------------#
 $telegram_ip_ranges = [
   ['lower' => '149.154.160.0', 'upper' => '149.154.175.255'],
   ['lower' => '91.108.4.0',    'upper' => '91.108.7.255']
 ];
 $ip_dec = (float) sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
 $ok = false;
 foreach ($telegram_ip_ranges as $telegram_ip_range) if (!$ok) {
   $lower_dec = (float) sprintf("%u", ip2long($telegram_ip_range['lower']));
   $upper_dec = (float) sprintf("%u", ip2long($telegram_ip_range['upper']));
   if ($ip_dec >= $lower_dec and $ip_dec <= $upper_dec) $ok = true;
 }
 if (!$ok) die("false");
#-----------------------#
$keyboard = json_encode([
  'keyboard' => [
    [['text' => "📊  اطلاعات سرویس"], ['text' => "🔑 اکانت تست"]]
  ],
  'resize_keyboard' => true
]);
$keyboardadmin = json_encode([
    'keyboard' => [
        [['text' => "📯 تنظیمات کانال"],['text' => "📊 آمار ربات"]],
        [['text' => "👨‍💻 اضافه کردن ادمین"],['text' => "❌ حذف ادمین"]],
        [['text' => "➕محدودیت ساخت اکانت تست برای کاربر"]],
        [['text' =>"➕محدودیت ساخت اکانت تست برای همه"]]
    ],
    'resize_keyboard' => true
]);
$channelkeyboard = json_encode([
    'keyboard' => [
        [['text' => "📣 تنظیم کانال جوین اجباری"]],
        [['text' => "🔑 روشن / خاموش کردن قفل کانال"]],
        [['text' => "🏠 بازگشت به منوی مدیریت"]]
    ],
    'resize_keyboard' => true
]);
$backuser = json_encode([
  'keyboard' => [
    [['text' => "🏠 بازگشت به منوی اصلی"]]
  ],
  'resize_keyboard' => true
]);
$backadmin = json_encode([
    'keyboard' => [
        [['text' => "🏠 بازگشت به منوی مدیریت"]]
    ],
    'resize_keyboard' => true
]);
#-----------------------#
$user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM user WHERE id = '$from_id' LIMIT 1"));
$Channel_locka_get = mysqli_fetch_assoc(mysqli_query($connect, "SELECT Channel_lock FROM channels"));
$Channel_locka = $Channel_locka_get['Channel_lock'];
$id_admin = mysqli_query($connect, "SELECT * FROM admin");
while($row = mysqli_fetch_assoc($id_admin)) {
    $admin_ids[] = $row['id_admin'];
}
$value_def=file_get_contents("data/value");
#-----------------------#
$channels = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM channels  LIMIT 1"));
$response = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=@{$channels['link']}&user_id=".$chat_id));
$tch = $response->result->status;

#-----------------------#
if ( !in_array($tch, ['member', 'creator', 'administrator']) && $Channel_locka == "on" && !in_array($from_id,$admin_ids)) {
    $text_channel = "   
    ⚠️کاربر گرامی ؛ شما عضو چنل ما نیستید
    ❗️@".$channels['link']."
    عضو کانال بالا شوید و مجدد 
    /start
    کنید❤️
    ";
    sendmessage($from_id,$text_channel,null);
} else {
    if ($text == "/start") {
        $text = "
        سلام $first_name 
        خوش آمدی
        ";
        sendmessage($from_id, $text, $keyboard);
        $connect->query("INSERT INTO user (id , step,limit_usertest) VALUES ('$from_id', 'none','$limit_usertest')");
    }
    if ($text == "📊  اطلاعات سرویس") {
        $textinfo = "
        نام کاربری خود را ارسال نمایید
            
    ⚠️ نام کاربری باید بدون کاراکترهای اضافه مانند @ ، فاصله ، خط تیره باشد. 
    ⚠️ نام کاربری باید انگلیسی باشد
    
        ";
        sendmessage($from_id, $textinfo, $backuser);
        $connect->query("UPDATE user SET step = 'getusernameinfo' WHERE id = '$from_id'");
    }
    if ($user['step'] == "getusernameinfo" && $text != "🏠 بازگشت به منوی اصلی") {
        if (preg_match('~^[a-z][a-z\d_]{3,32}$~i', $text)) {
            $data_useer = getuser($text);
            if (isset($data_useer['username'])) {
                #-------------status----------------#
                $status = $data_useer['status'];
                $status_var = [
                    'active' => '✅فعال',
                    'limited' => '🔚پایان حجم',
                    'disabled' => '❌غیرفعال',
                    'expired' => 'نامشخص'
                ][$status];
                #--------------expire---------------#
                $expirationDate = $data_useer['expire'] ? jdate('Y/m/d', $data_useer['expire']) : "نامحدود";
                #-------------data_limit----------------#
                $LastTraffic = $data_useer['data_limit'] ? formatBytes($data_useer['data_limit']) : "نامحدود";
                #---------------RemainingVolume--------------#
                $output =  $data_useer['data_limit'] - $data_useer['used_traffic'];
                $RemainingVolume = $data_useer['data_limit'] ? formatBytes($output) : "نامحدود";
                #---------------used_traffic--------------#
                $usedTrafficGb = $data_useer['used_traffic'] ? formatBytes($data_useer['used_traffic']) : "مصرف نشده";
                #--------------day---------------#
                $timeDiff = $data_useer['expire'] - time();
                $day = $data_useer['expire'] ? floor($timeDiff / 86400) . " روز" : "نامحدود";
                #-----------------------------#


                $keyboardinfo = json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => $data_useer['username'],'callback_data'=>"dalsl"],
                            ['text' => 'نام کاربری :', 'callback_data' => 'username'],
                        ], [
                            ['text' => $status_var, 'callback_data' => 'status_var'],
                            ['text' => 'وضعیت:', 'callback_data' => 'status_var'],
                        ], [
                            ['text' => $expirationDate, 'callback_data' => 'expirationDate'],
                            ['text' => 'زمان پایان:', 'callback_data' => 'expirationDate'],
                        ], [
                            ['text' => $day, 'callback_data' => 'روز'],
                            ['text' => 'زمان باقی مانده تا پایان سرویس:', 'callback_data' => 'day'],
                        ], [
                            ['text' => $LastTraffic, 'callback_data' => 'LastTraffic'],
                            ['text' => 'حجم کل سرویس :', 'callback_data' => 'LastTraffic'],
                        ], [
                            ['text' => $usedTrafficGb, 'callback_data' => 'expirationDate'],
                            ['text' => 'حجم مصرف شده سرویس :', 'callback_data' => 'expirationDate'],
                        ], [
                            ['text' => $RemainingVolume, 'callback_data' => 'RemainingVolume'],
                            ['text' => 'حجم باقی مانده  سرویس :', 'callback_data' => 'RemainingVolume'],
                        ]
                    ]
                ]);
                sendmessage($from_id, "📊  اطلاعات سرویس :", $keyboardinfo);
                sendmessage($from_id, " یک گزینه را انتخاب کنید", $keyboard);
            } else {
                sendmessage($from_id, "نام کاربری وجود ندارد", $keyboard);
            }
            $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");
        } else {
            $textusernameinva = " 
                ❌نام کاربری نامعتبر است
            
            🔄 مجددا نام کاربری خود  را ارسال کنید
                ";
            sendmessage($from_id, $textusernameinva, $back);
            $connect->query("UPDATE user SET step = 'getusernameinfo' WHERE id = '$from_id'");
        }
    }
    if ($text == "🔑 اکانت تست") {
        if ($user['limit_usertest'] != 0) {
            $textusertest = "
          
            👤برای ساخت اشتراک تست یک نام کاربری انگلیسی ارسال نمایید.
    
    ⚠️ نام کاربری باید دارای شرایط زیر باشد
    
    1- فقط انگلیسی باشد و حروف فارسی نباشد
    2- کاراکترهای اضافی مانند @،#،% و... را نداشته باشد.
    3 - نام کاربری باید بدون فاصله باشد.
    
    🛑 در صورت رعایت نکردن موارد بالا با خطا مواجه خواهید شد
          ";
            sendmessage($from_id, $textusertest, $backuser);
            $connect->query("UPDATE user SET step = 'crateusertest' WHERE id = '$from_id'");
            $limit_usertest = $user['limit_usertest'] - 1;
            $connect->query("UPDATE user SET limit_usertest = '$limit_usertest' WHERE id = '$from_id'");
        } else {
            sendmessage($from_id, "⚠️ اجازه ساخت اشتراک تست را ندارید.", $keyboard);
        }
    }
#-----------------------------------#
    if ($user['step'] == "crateusertest" && $text != "🏠 بازگشت به منوی اصلی") {
        if (preg_match('/^[a-zA-Z0-9_]{3,32}$/', $text)) {
            $Allowedusername = getuser($text);
            if (empty($Allowedusername['username'])) {
                $date = strtotime("+" . $time . "hours");
                $timestamp = strtotime(date("Y-m-d H:i:s", $date));
                $username = $text;
                $expire = $timestamp;
                $data_limit = $val * 1000000;
                $config_test = adduser($username, $expire, $data_limit);
                $data_test = json_decode($config_test, true);
                $output_config_link = $data_test['subscription_url'];
                $textcreatuser = "
                    
    🔑 اشتراک شما با موفقیت ساخته شد.
    ⏳ زمان اشتراک تست $time ساعت
    🌐 حجم سرویس تست $val مگابایت
    
    لینک اشتراک شما   :
    ```
    $output_config_link
    ```
                    ";
                sendmessage($from_id, $textcreatuser, $keyboard);
                $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");
            }
        } else {
            if ($text != "🏠 بازگشت به منوی اصلی") {
                sendmessage($from_id, "⛔️ نام کاربری معتبر نیست", $keyboard);
            }
            $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");
        }
    }
    if ($text == "🏠 بازگشت به منوی اصلی") {
        $textback = "به صفحه اصلی بازگشتید!";
        sendmessage($from_id, $textback, $keyboard);
        $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");
    }
}
//------------------------------------------------------------------------------



#----------------admin------------------#
if(!in_array($from_id,$admin_ids)) return;
if($text == "panel"){
    sendmessage($from_id,"به پنل ادمین خوش آمدید",$keyboardadmin);
}
if ($text == "🏠 بازگشت به منوی مدیریت"){
    sendmessage($from_id,"به پنل ادمین بازگشتید! ",$keyboardadmin);
    $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");
}
if ($text =="🔑 روشن / خاموش کردن قفل کانال"){
if($Channel_locka=="off"){
    sendmessage($from_id,"عضویت اجباری روشن گردید",$keyboardadmin);
    $connect->query("UPDATE channels SET Channel_lock = 'on'");
}
else{
    sendmessage($from_id,"عضویت اجباری خاموش گردید",$keyboardadmin);
    $connect->query("UPDATE channels SET Channel_lock = 'off'");
}
}
if($text =="📣 تنظیم کانال جوین اجباری") {
    $text_channel = "
    برای تنظیم کانال عضویت اجباری لطفا آیدی کانال خود را بدون @ وارد نمایید.
    
    کانال فعلی شما: @".$channels['link'];
    sendmessage($from_id, $text_channel, $backadmin);
    $connect->query("UPDATE user SET step = 'addchannel' WHERE id = '$from_id'");
}
if($user['step'] == "addchannel" && $text !="🏠 بازگشت به منوی مدیریت"){
    $text_set_channel="
    🔰 کانال با موفقیت تنظیم گردید.
     برای  روشن کردن عضویت اجباری از منوی ادمین دکمه 📣 تنظیم کانال جوین اجباری  را بزنید
    ";
    sendmessage($from_id, $text_set_channel, $keyboardadmin);
    $connect->query("UPDATE channels SET link = '$text'");
    $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");

}
if ($text == "👨‍💻 اضافه کردن ادمین"){
    sendmessage($from_id, "🌟آیدی عددی ادمین جدید را ارسال نمایید.", $backadmin);
    $connect->query("UPDATE user SET step = 'addadmin' WHERE id = '$from_id'");
}
if($user['step'] == "addadmin" && $text !="🏠 بازگشت به منوی مدیریت"){
    sendmessage($from_id, "🥳ادمین با موفقیت اضافه گردید", $keyboardadmin);
    $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");
    $connect->query("INSERT INTO admin (id_admin) VALUES ('$text')");

}
if($text == "❌ حذف ادمین"){
    sendmessage($from_id, "🛑 آیدی عددی ادمین را ارسال کنید.", $backadmin);
    $connect->query("UPDATE user SET step = 'deleteadmin' WHERE id = '$from_id'");
}
if ($user['step'] == "deleteadmin" && $text !="🏠 بازگشت به منوی مدیریت"){
    sendmessage($from_id, "✅ ادمین با موفقیت حذف گردید.", $keyboardadmin);
    $connect->query("DELETE FROM admin WHERE id_admin = '$text'");
    $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");

}
if ($text == "➕محدودیت ساخت اکانت تست برای کاربر"){
    $text_add_user_admin = "
    ⚜️ آیدی عددی کاربر را ارسال کنید 
توضیحات : در این بخش میتوانید محدودیت ساخت اکانت تست را برای کاربر تغییر دهید. بطور پیشفرض محدودیت ساخت عدد 1 است
    ";
    sendmessage($from_id, $text_add_user_admin, $backadmin);
    $connect->query("UPDATE user SET step = 'add_limit_usertest_foruser' WHERE id = '$from_id'");
}
if ($user['step'] == "add_limit_usertest_foruser" && $text !="🏠 بازگشت به منوی مدیریت") {
    sendmessage($from_id, "آیدی عددی دریافت شد لطفا تعداد ساخت اکانت تست را ارسال کنید", $backadmin);
    file_put_contents("data/value",$text);
    $connect->query("UPDATE user SET step = 'get_number_limit' WHERE id = '$from_id'");
}
if ($user['step'] == "get_number_limit" && $text !="🏠 بازگشت به منوی مدیریت") {
    sendmessage($from_id, "محدودیت برای کاربر تنظیم گردید.", $keyboardadmin);
    $id_user_set = $text;
    $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");
    $connect->query("UPDATE user SET limit_usertest = '$text' WHERE id = '$value_def'");
}
if ($text == "➕محدودیت ساخت اکانت تست برای همه"){
    sendmessage($from_id, "تعداد ساخت اکانت تست را  وارد نمایید.", $backadmin);
    $connect->query("UPDATE user SET step = 'limit_usertest_allusers' WHERE id = '$from_id'");
}
if ($user['step'] == "limit_usertest_allusers"  && $text !="🏠 بازگشت به منوی مدیریت"){
    sendmessage($from_id, "محدودیت ساخت اکانت برای تمام کاربران تنظیم شد", $keyboardadmin);
    $connect->query("UPDATE user SET limit_usertest = '$text'");
    $connect->query("UPDATE user SET step = 'home' WHERE id = '$from_id'");

}
if($text == "📯 تنظیمات کانال") {
    sendmessage($from_id, "یکی از گزینه های زیر را انتخاب کنید", $channelkeyboard);
}
if ($text == "📊 آمار ربات"){
    if (!empty(token_panel())){
        $textpanel = "✅ پنل متصل است";
    }
    else{
        $textpanel = "❌ پنل متصل نیست";
    }
    $statisticssql = $connect->query("SELECT COUNT(id) FROM user");
    $statistics = $statisticssql->fetch_array(MYSQLI_NUM);
    $text_statistics = "
    👤 تعداد کاربران : $statistics[0]
    
    🖥 وضعیت پنل مرزبان  : $textpanel
    ";
    sendmessage($from_id, "$text_statistics", $keyboardadmin);
}

<?php
include('function.php');
echo "<body style=background-color:#000;color:#fff>hello</body>";
#------------info----------------#
$token = "6175382184:AAHiTfszggQhJbFT04oJr3sNhXzCf3zpEhQ";
#-----------------------------#
define('API_KEY', $token);
#-----------------------------#
$update = json_decode(file_get_contents("php://input"));
if (isset($update->message)) {
    $from_id    = $update->message->from->id;
    $chat_id    = $update->message->chat->id;
    $text       = $update->message->text;
    $first_name = $update->message->from->first_name;
    $message_id = $update->message->message_id;
}
#-----------------------------#
if (!is_dir("data")) {
    mkdir("data");
}
if (!is_dir("data/user")) {
    mkdir("data/user");
}
if (!is_dir("data/user/$chat_id")) {
    mkdir("data/user/$chat_id");
}
if (!file_exists("data/user/$chat_id/step")) {
    file_put_contents("data/user/$chat_id/step", null);
}
#-----------------------------#
$step = file_get_contents("data/user/$from_id/step");
$o = "🏠 بازگشت به منوی اصلی";
$back = json_encode([
    'keyboard' => [
        [['text' => "$o"]],
    ],
    'resize_keyboard' => true
]);
$key1 = json_encode([
    'keyboard' => [
        [['text' => "📊 اطلاعات سرویس"]],
    ],
    'resize_keyboard' => true
]);
#-------------start----------------#
if ($text == "/start") {
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "
سلام $first_name, عزیز👋
 به ربات  ما خوش آمدی.😊",
        'reply_markup' => $key1,
        'parse_mode' => "Markdown",
        'reply_to_message_id' => $message_id,
    ]);
    file_put_contents("data/user/$from_id/step", "home");
}
#-------------back----------------#
else if ($text == $o) {
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "به صفحه اصلی بازگشتید!",
        'reply_markup' => $key1,
        'parse_mode' => "Markdown",
        'reply_to_message_id' => $message_id,
    ]);
    file_put_contents("data/user/$from_id/step", "home");
}
#-----------------------------------#
if ($text == "📊 اطلاعات سرویس") {
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "نام کاربری خود را وارد نمایید
        
        
⚠️ نام کاربری باید بدون کاراکترهای اضافه مانند @ ، فاصله ، خط تیره باشد. 
⚠️ نام کاربری باید انگلیسی باشد
        ",
        'reply_markup' => $back,
        'parse_mode' => "Markdown",
        'reply_to_message_id' => $message_id,
    ]);
    file_put_contents("data/user/$from_id/step", "Service Inquiry");
} elseif ($step == "Service Inquiry" && $text != $o) {
    $username = $text;
    if (preg_match('/^[A-Za-z0-9_]+$/', $username)) {

        $data_useer = getuser($text);
        if (isset($data_useer['username'])) {
            #-------------status----------------#
            $status = $data_useer['status'];
            switch ($status) {
                case 'active':
                    $status_var = "✅فعال";
                    break;
                case 'limited':
                    $status_var = "🔚پایان حجم";
                    break;
                case 'disabled':
                    $status_var = "❌غیرفعال";
                    break;

                default:
                    $status_var = "🤷‍♂️نامشخص";
                    break;
            }


            #-----------------------------#
            $timestamp = $data_useer['expire'];
            $expirationDate = date('Y/m/d', $timestamp);
            $date_time_obj = new DateTime($expirationDate);
            $current_date = date('Y/m/d');
            if ($date_time_obj->format('Y/m/d') == $current_date) {
                $expirationDate = "نامحدود";
            }
            #-----------------------------#
            $LastTraffic = round($data_useer['data_limit'] / 1073741824, 2) . "GB";
            if (round($data_useer['data_limit'] / 1073741824, 2) < 1) {
                $LastTraffic = round($data_useer['data_limit'] / 1073741824, 2) * 1000 . "MB";
            }
            if (round($data_useer['data_limit'] / 1073741824, 2) == 0) {
                $LastTraffic = "نامحدود";
                $RemainingVolume = "نامحدود";
            }
            #-----------------------------#
            $usedTrafficGb = round($data_useer['used_traffic'] / 1073741824, 2) . "GB";
            if (round($data_useer['used_traffic'] / 1073741824, 2) < 1) {
                $usedTrafficGb = round($data_useer['used_traffic'] / 1073741824, 2) * 1000 . "MB";
            }
            if (round($data_useer['used_traffic'] / 1073741824, 2) == 0) {
                $usedTrafficGb = "مصرف نشده";
            }
            #-----------------------------#
            if (round($data_useer['data_limit'] / 1073741824, 2) != 0) {
                $min = round($data_useer['data_limit'] / 1073741824, 2) - round($data_useer['used_traffic'] / 1073741824, 2);
                $RemainingVolume  = $min . "GB";
                if ($min < 1) {
                    $RemainingVolume = $min * 1000 . "MB";
                }
            }
            #-----------------------------#

            $currentTime = time();
            $timeDiff = $data_useer['expire'] - $currentTime;

            if ($timeDiff > 0) {
                $day = floor($timeDiff / 86400) . " Day";
            } else {
                $day = "نامحدود";
            }
            #-----------------------------#


            $keyboardinfo = [
                'inline_keyboard' => [
                    [
                        ['text' => $data_useer['username'], 'callback_data' => 'username'],
                        ['text' => 'نام کاربری :', 'callback_data' => 'username'],
                    ], [
                        ['text' => $status_var, 'callback_data' => 'status_var'],
                        ['text' => 'وضعیت:', 'callback_data' => 'status_var'],
                    ], [
                        ['text' =>  $expirationDate, 'callback_data' => 'expirationDate'],
                        ['text' => 'زمان پایان:', 'callback_data' => 'expirationDate'],
                    ], [
                        ['text' =>  $day, 'callback_data' => 'day'],
                        ['text' => 'زمان باقی مانده تا پایان سرویس:', 'callback_data' => 'day'],
                    ], [
                        ['text' =>  $LastTraffic, 'callback_data' => 'LastTraffic'],
                        ['text' => 'حجم کل سرویس :', 'callback_data' => 'LastTraffic'],
                    ], [
                        ['text' =>  $usedTrafficGb, 'callback_data' => 'expirationDate'],
                        ['text' => 'حجم مصرف شده سرویس :', 'callback_data' => 'expirationDate'],
                    ], [
                        ['text' =>  $RemainingVolume, 'callback_data' => 'RemainingVolume'],
                        ['text' => 'حجم باقی مانده  سرویس :', 'callback_data' => 'RemainingVolume'],
                    ]
                ]
            ];
            $parameters = bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "📊 اطلاعات سرویس شما :",
                'parse_mode' => 'Markdown',
                'reply_markup' => json_encode($keyboardinfo),
                'reply_to_message_id' => $message_id
            ]);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "لطفا یک گزینه را انتخاب کنید :",
                'parse_mode' => 'Markdown',
                'reply_markup' => $key1
            ]);
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "نام کاربری وجود ندارد",
                'parse_mode' => 'Markdown',
                'reply_markup' => $key1
            ]);
        }
        file_put_contents("data/user/$from_id/step", "home");
    } else {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "❌نام کاربری نامعتبر است
        
        🔄 مجددا نام کاربری خود  را ارسال کنید",
            'reply_markup' => $back,
            'parse_mode' => "Markdown",
            'reply_to_message_id' => $message_id,
        ]);
    }
}
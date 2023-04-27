<?php
/*
pv  => @gholipour3
channel => @botpanelmarzban
*/
//-----------------------------database-------------------------------
$dbname = "databasename"; //  نام دیتابیس
$username = "username"; // نام کاربری دیتابیس
$password = 'password'; // رمز عبور دیتابیس
$connect = mysqli_connect("localhost", $username, $password, $dbname);
//-----------------------------info-------------------------------

defined('API_KEY') or define('API_KEY', 'توکن ربات');// توکن ربات خود را وارد کنید
defined('limit_usertest') or define('limit_usertest', 10);//   محدودیت ساخت اکانت تست 
defined('val') or define('val', 100);// حجم اکانت تست واحد مگابایت
defined('time') or define('time', 1); // زمان اکانت تست  واحد ساعت
defined('adminnumber') or define('adminnumber', 5522424631);// آیدی عددی ادمین
//-----------------------------text panel-------------------------------
$textdatabot = mysqli_query($connect, "SELECT * FROM textbot");
$datatxtbot = array();
foreach ($textdatabot as $row) {
    $datatxtbot[] = array(
        'id_text' => $row['id_text'],
        'text' => $row['text']
    );
}
$datatextbot = array(
    'text_usertest' => '',
    'text_info' => '',
    'text_support' => '',
    'text_help' => '',
    'text_start' => '',
    'text_bot_off' => '',
    'text_dec_info' => '',
    'text_dec_usertest' => '',
    'text_fq' => ''
);
foreach ($datatxtbot as $item) {
    if (isset($datatextbot[$item['id_text']])) {
        $datatextbot[$item['id_text']] = $item['text'];
    }
}
$keyboard = json_encode([
    'keyboard' => [
            [['text' => $datatextbot['text_info']], ['text' => $datatextbot['text_usertest']]],
            [['text' => $datatextbot['text_support']],['text' => $datatextbot['text_help']]],
            [['text' => $datatextbot['text_fq']]]
    ],
    'resize_keyboard' => true
]);
$keyboardadmin = json_encode([
    'keyboard' => [
        [['text' => "📯 تنظیمات کانال"],['text' => "📊 آمار ربات"]],
        [['text' => "📡 وضعیت  ربات"]],
        [['text' => "📨 ارسال پیام به کاربر"],['text' => "📝 تنظیم متون ربات"]],
        [['text' => "📜 مشاهده لیست  ادمین ها"]],
        [['text' => "👨‍💻 اضافه کردن ادمین"],['text' => "❌ حذف ادمین"]],
        [['text' => "🚫 مسدودی کاربر"]],
        [['text' => "📚 بخش آموزش "],['text' => "🖥 پنل مرزبان"]],
        [['text' => "♨️بخش قوانین"]],
        [['text' => "🏠 بازگشت به منوی اصلی"]]
    ],
    'resize_keyboard' => true
]);
$keyboardhelpadmin = json_encode([
    'keyboard' => [
        [['text' => "📚 اضافه کردن آموزش"],['text' => "❌ حذف آموزش "]],
        [['text' => "🏠 بازگشت به منوی مدیریت"]]
    ],
    'resize_keyboard' => true
]);
$blockuserkey = json_encode([
    'keyboard' => [
        [['text' => "🔒 مسدود کردن کاربر"],['text' => "🔓 باز کردن مسدود کاربر"]],
        [['text' => "🏠 بازگشت به منوی مدیریت"]]
    ],
    'resize_keyboard' => true
]);
$confrimrolls = json_encode([
    'keyboard' => [
        [['text' => "✅ قوانین را می پذیرم"]],
    ],
    'resize_keyboard' => true
]);
$rollkey = json_encode([
    'keyboard' => [
        [['text' => "💡 روشن / خاموش کردن تایید قوانین"],['text' => "⚖️ متن قانون"]],
        [['text' => "🏠 بازگشت به منوی مدیریت"]]
    ],
    'resize_keyboard' => true
]);
$sendmessageuser = json_encode([
    'keyboard' => [
        [['text' => "✉️ ارسال همگانی"],['text' => "📤 فوروارد همگانی"]],
        [['text' => "✍️ ارسال پیام برای یک کاربر"]],
        [['text' => "🏠 بازگشت به منوی مدیریت"]]
    ],
    'resize_keyboard' => true
]);
$Feature_status = json_encode([
    'keyboard' => [
        [['text' => "قابلیت مشاهده اطلاعات اکانت"]],
        [['text' => "قابلیت اکانت تست"],['text' => "قابلیت آموزش"]],
        [['text' => "🏠 بازگشت به منوی مدیریت"]]
    ],
    'resize_keyboard' => true
]);
$keyboardmarzban =  json_encode([
    'keyboard' => [
        [['text' => "➕محدودیت ساخت اکانت تست برای کاربر"]],
        [['text' =>"➕محدودیت ساخت اکانت تست برای همه"]],
        [['text' => '🔌 وضعیت پنل '],['text' => "🖥 اضافه کردن پنل  مرزبان "]],
        [['text' => "❌ حذف پنل"]],
        [['text' => "🏠 بازگشت به منوی مدیریت"]]
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
$result = $connect->query("SHOW TABLES LIKE 'marzban_panel'");
$table_exists = ($result->num_rows > 0);
if ($table_exists) {
    $namepanel = [];
    $marzbnget = mysqli_query($connect, "SELECT * FROM marzban_panel");
    while ($row = mysqli_fetch_assoc($marzbnget)) {
        $namepanel[] = [$row['name_panel']];
    }
    $list_marzban_panel = [
        'keyboard' => [],
        'resize_keyboard' => true,
    ];
    $list_marzban_panel['keyboard'][] = [
        ['text' => "🏠 بازگشت به منوی مدیریت"],
    ];
    foreach ($namepanel as $button) {
        $list_marzban_panel['keyboard'][] = [
            ['text' => $button[0]]
        ];
    }
    $json_list_marzban_panel = json_encode($list_marzban_panel);
    $help = [];
    $helpname = mysqli_query($connect, "SELECT * FROM help");
    while ($row = mysqli_fetch_assoc($helpname)) {
        $help[] = [$row['name_os']];
    }
    $help_arr = [
        'keyboard' => [],
        'resize_keyboard' => true,
    ];
    $help_arr['keyboard'][] = [
        ['text' => "🏠 بازگشت به منوی اصلی"],
    ];
    foreach ($help as $button) {
        $help_arr['keyboard'][] = [
            ['text' => $button[0]]
        ];
    }
    $json_list_help = json_encode($help_arr);
}
$list_marzban_panel_users = [
    'keyboard' => [],
    'resize_keyboard' => true,
];
$list_marzban_panel_users['keyboard'][] = [
    ['text' => "🏠 بازگشت به منوی اصلی"],
];
foreach($namepanel as $button) {
    $list_marzban_panel_users['keyboard'][] = [
        ['text' => $button[0]]
    ];
}
$list_marzban_panel_user = json_encode($list_marzban_panel_users);
$textbot = json_encode([
    'keyboard' => [
        [['text' => "تنظیم متن شروع"],['text' => "دکمه اطلاعات سرویس"]],
        [['text' => "دکمه اکانت تست"],['text' => "دکمه سوالات متداول"]],
        [['text' => "متن دکمه 📚  آموزش"],['text' => "متن دکمه ☎️ پشتیبانی "]],
        [['text' => "📝 تنظیم متن توضیحات اطلاعات سرویس "]],
        [['text' => "📝 تنظیم متن توضیحات  سوالات متداول"]],
        [['text' => "📝 تنظیم متن توضیحات پشتیبانی"]],
        [['text' => "🏠 بازگشت به منوی مدیریت"]]
    ],
    'resize_keyboard' => true
]);

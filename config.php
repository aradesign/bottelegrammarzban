<?php
//-----------------------------database-------------------------------
$dbname = "whmcscom_bot"; //  Name db
$username = "whmcscom_bot"; // Username db
$password = '@LW,+Azw0aGn'; // Pass username db
$connect = mysqli_connect("localhost", $username, $password, $dbname);
//-----------------------------info-------------------------------

defined('API_KEY') or define('API_KEY', '6175382184:AAGoQZayCEw8puKlM-bamoNiuqyfZehzsr4');
defined('limit_usertest') or define('limit_usertest', 10);
defined('val') or define('val', 100);
defined('time') or define('time', 1);
defined('adminnumber') or define('adminnumber', 5522424631);
//-----------------------------text panel-------------------------------
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
        [['text' => "📜 مشاهده لیست  ادمین ها"],['text' => "🖥 تنظیمات پنل مرزبان"]]
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
$namepanel = [];
$marzbnget = mysqli_query($connect, "SELECT * FROM marzban_panel");
while($row = mysqli_fetch_assoc($marzbnget)) {
    $namepanel[] = [$row['name_panel']];
}
$list_marzban_panel = [
    'keyboard' => [],
    'resize_keyboard' => true,
];
$list_marzban_panel['keyboard'][] = [
    ['text' => "🏠 بازگشت به منوی مدیریت"],
];
foreach($namepanel as $button) {
    $list_marzban_panel['keyboard'][] = [
        ['text' => $button[0]]
    ];
}
$json_list_marzban_panel = json_encode($list_marzban_panel);
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


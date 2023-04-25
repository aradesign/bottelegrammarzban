<?php
global $connect;
include('config.php');
//-----------------------------------------------------------------
try {
    $result = $connect->query("SHOW TABLES LIKE 'user'");
    $table_exists = ($result->num_rows > 0);

    if (!$table_exists) {
        $connect->query("CREATE TABLE user (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        limit_usertest int(100) NOT NULL,
        Processing_value varchar(100000) NOT NULL,
        step varchar(5000) NOT NULL,
        description_blocking varchar(5000) NOT NULL,
        User_Status varchar(500) NOT NULL)");
        echo "table user✅</br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
//-----------------------------------------------------------------
try {
    $result = $connect->query("SHOW TABLES LIKE 'help'");
    $table_exists = ($result->num_rows > 0);

    if (!$table_exists) {
        $connect->query("CREATE TABLE help (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name_os varchar(500) NOT NULL,
        Media_os varchar(5000) NOT NULL,
        type_Media_os varchar(500) NOT NULL,
        Description_os TEXT(10000) NOT NULL)");
        echo "table help✅</br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
//-----------------------------------------------------------------
try {
    $result = $connect->query("SHOW TABLES LIKE 'textbot'");
    $table_exists = ($result->num_rows > 0);
      $text_info = "
      نام کاربری خود را ارسال نمایید
            
    ⚠️ نام کاربری باید بدون کاراکترهای اضافه مانند @ ، فاصله ، خط تیره باشد. 
    ⚠️ نام کاربری باید انگلیسی باشد
      ";
      $text_usertest = "
      👤برای ساخت اشتراک تست یک نام کاربری انگلیسی ارسال نمایید.
    
    ⚠️ نام کاربری باید دارای شرایط زیر باشد
    
    1- فقط انگلیسی باشد و حروف فارسی نباشد
    2- کاراکترهای اضافی مانند @،#،% و... را نداشته باشد.
    3 - نام کاربری باید بدون فاصله باشد.
    
    🛑 در صورت رعایت نکردن موارد بالا با خطا مواجه خواهید شد
      ";
    $helpt = "📚  آموزش";
    $supportt = "☎️ پشتیبانی";
    $bot_off = " ❌ ربات خاموش است ، لطفا دقایقی دیگر مراجعه کنید";
    if (!$table_exists) {
        $connect->query("CREATE TABLE textbot (
        text_info varchar(100000) NOT NULL,
        text_dec_info varchar(100000) NOT NULL,
        text_usertest varchar(100000) NOT NULL,
        text_dec_usertest varchar(100000) NOT NULL,
        text_help varchar(1000) NOT NULL,
        text_support varchar(1000) NOT NULL,
        text_dec_bot_off varchar(7000) NOT NULL,
        text_start varchar(100000) NOT NULL)");
        echo "table textbot✅</br>";
        $connect->query("INSERT INTO textbot (text_start,text_info,text_usertest,text_dec_info,text_dec_usertest,text_help,text_support,text_dec_bot_off ) VALUES ('سلام خوش آمدید','📊  اطلاعات سرویس','🔑 اکانت تست','$text_info','$text_usertest','$helpt','$supportt','$bot_off')");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
//-----------------------------------------------------------------
try {
    $result = $connect->query("SHOW TABLES LIKE 'setting'");
    $table_exists = ($result->num_rows > 0);

    if (!$table_exists) {
        $connect->query("CREATE TABLE setting (
        Bot_Status varchar(200) NOT NULL,
        count_usertest varchar(5000) NOT NULL)");
        echo "table setting✅</br>";
                $connect->query("INSERT INTO setting (count_usertest,Bot_Status) VALUES ('0','✅ روشن ')");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

//-----------------------------------------------------------------
try {
    $result = $connect->query("SHOW TABLES LIKE 'admin'");
    $table_exists = ($result->num_rows > 0);
    if ($table_exists) {
        $id_admin = mysqli_query($connect, "SELECT * FROM admin");
        while ($row = mysqli_fetch_assoc($id_admin)) {
            $admin_ids[] = $row['id_admin'];
        }
        if (!in_array($adminnumber, $admin_ids)) {
            $connect->query("INSERT INTO admin (id_admin) VALUES ('$adminnumber')");
            echo "table admin update✅</br>";
        }
    } else {
        $connect->query("CREATE TABLE admin (
        id_admin varchar(5000) NOT NULL)");
        $connect->query("INSERT INTO admin (id_admin) VALUES ('$adminnumber')");
        echo "table admin ✅</br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
//-----------------------------------------------------------------
try {

    $result = $connect->query("SHOW TABLES LIKE 'channels'");
    $table_exists = ($result->num_rows > 0);

    if (!$table_exists) {
        $connect->query("CREATE TABLE channels (
Channel_lock varchar(200) NOT NULL,
link varchar(200) NOT NULL )");
        $connect->query("INSERT INTO channels (link,Channel_lock) VALUES ('test','off')");
        echo "table channels ✅ </br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
//--------------------------------------------------------------
try {

    $result = $connect->query("SHOW TABLES LIKE 'marzban_panel'");
    $table_exists = ($result->num_rows > 0);

    if (!$table_exists) {
        $connect->query("CREATE TABLE marzban_panel (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name_panel varchar(2000) NOT NULL,
        url_panel varchar(2000) NOT NULL,
        username_panel varchar(200) NOT NULL,
        password_panel varchar(200) NOT NULL )");
        echo "table marzban_panel ✅ </br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
//-----------------------------------------------------------------

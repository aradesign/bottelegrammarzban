<?php
global $connect;
include('config.php');
//-----------------------------------------------------------------
try {
    $result = $connect->query("SHOW TABLES LIKE 'user'");
    $table_exists = ($result->num_rows > 0);

    if (!$table_exists) {
        $connect->query("CREATE TABLE user (
        id varchar(500)  PRIMARY KEY,
        limit_usertest int(100) NOT NULL,
        roll_Status bool NOT NULL,
        Processing_value varchar(1000) NOT NULL,
        step varchar(5000) NOT NULL,
        description_blocking varchar(5000) NOT NULL,
        User_Status varchar(500) NOT NULL)");
        echo "table user✅</br>";
    } else {
        $Check_filde = $connect->query("SHOW COLUMNS FROM user LIKE 'Processing_value'");
        if (mysqli_num_rows($Check_filde) != 1) {
            $connect->query("ALTER TABLE user ADD Processing_value VARCHAR(1000)");
            $connect->query("UPDATE user SET Processing_value = 'none'");
            echo "The Processing_Value field was added ✅";
        }
        $Check_filde = $connect->query("SHOW COLUMNS FROM user LIKE 'roll_Status'");
        if (mysqli_num_rows($Check_filde) != 1) {
            $connect->query("ALTER TABLE user ADD roll_Status bool");
            $connect->query("UPDATE user SET roll_Status = false");
            echo "The roll_Status field was added ✅";
        }
        $Check_filde = $connect->query("SHOW COLUMNS FROM user LIKE 'description_blocking'");
        if (mysqli_num_rows($Check_filde) != 1) {
            $connect->query("ALTER TABLE user ADD description_blocking VARCHAR(5000)");
            echo "The description_blocking field was added ✅";
        }
        $Check_filde = $connect->query("SHOW COLUMNS FROM user LIKE 'User_Status'");
        if (mysqli_num_rows($Check_filde) != 1) {
            $connect->query("ALTER TABLE user ADD User_Status VARCHAR(500)");
            echo "The User_Status field was added ✅";
        }
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
        Description_os TEXT NOT NULL)");
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
    $support_dec = "
    پیام خود را ارسال کنید کنید :
        ⚠️ برای دریافت پیام حتما باید فوروارد حساب کاربری تان باز باشد تا پاسخ ادمین را دریافت کنید.
    ";
    $text_roll = "
    ♨️ قوانین استفاده از خدمات ما

1 - به اطلاعیه هایی که داخل کانال گذاشته می شود حتما توجه کنید.
2- در صورتی که اطلاعیه ای در مورد قطعی در کانال گذاشته نشده به اکانت پشتیبانی پیام دهید
3- سرویس ها را از طریق پیامک ارسال نکنید برای ارسال پیامک می توانید از طریق ایمیل ارسال کنید.
    ";
    $text_dec_fq = " 
    💡 سوالات متداول


❓ فیلترشکن شما آیپی ثابته ؟ میتونم برای صرافی های ارز دیجیتال استفاده کنم؟

      • به دلیل وضعیت نت و محدودیت های کشور سرویس ما مناسب ترید نیست و فقط لوکیشن‌ ثابته.


❓ اگه قبل از منقضی شدن اکانت، تمدیدش کنم روزهای باقی مانده میسوزد؟

      • خیر، روزهای باقیمونده اکانت موقع تمدید حساب میشن و اگه مثلا 5 روز قبل از منقضی شدن اکانت 1 ماهه خودتون اون رو تمدید کنید 5 روز باقیمونده + 30 روز تمدید میشه.


❓ اگه به یک اکانت بیشتر از حد مجاز متصل شیم چه اتفاقی میافته؟

      • در این صورت حجم سرویس شما زود تمام خواهد شد.


❓ فیلترشکن شما از چه نوعیه؟

      • فیلترشکن های ما v2ray است و پروتکل‌های مختلفی رو ساپورت میکنیم تا حتی تو دورانی که اینترنت اختلال داره بدون مشکل و افت سرعت بتونید از سرویستون استفاده کنید.


❓ فیلترشکن از کدوم کشور است؟

      • سرور فیلترشکن ما از کشور  آلمان است


❓ چطور باید از این فیلترشکن استفاده کنم؟

      • برای آموزش استفاده از برنامه، روی دکمه «📚 آموزش» بزنید.


❓ فیلترشکن وصل نمیشه، چیکار کنم؟

      • به همراه یک عکس از پیغام خطایی که میگیرید به پشتیبانی مراجعه کنید.


❓ فیلترشکن شما تضمینی هست که همیشه مواقع متصل بشه؟

      • به دلیل قابل پیش‌بینی نبودن وضعیت نت کشور، امکان دادن تضمین نیست فقط می‌تونیم تضمین کنیم که تمام تلاشمون رو برای ارائه سرویس هر چه بهتر انجام بدیم.


❓ امکان بازگشت وجه دارید؟

      • امکان بازگشت وجه در صورت حل نشدن مشکل از سمت ما وجود دارد.



💡 در صورتی که جواب سوالتون رو نگرفتید میتونید به «پشتیبانی» مراجعه کنید.";
    if (!$table_exists) {
        $connect->query("CREATE TABLE textbot (
        id_text varchar(2000) NOT NULL,
        text TEXT NOT NULL)");
        echo "table textbot✅</br>";
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_start','سلام خوش آمدید')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_usertest','🔑 اکانت تست')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_dec_usertest','$text_usertest')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_info','📊  اطلاعات سرویس')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_dec_info','$text_info')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_support','☎️ پشتیبانی')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_dec_support','$support_dec')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_help','📚  آموزش')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_bot_off',' ❌ ربات خاموش است ، لطفا دقایقی دیگر مراجعه کنید')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_roll','$text_roll')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_','$text_roll')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_fq','❓ سوالات متداول')");
        $connect->query("INSERT INTO textbot (id_text,text) VALUES ('text_dec_fq','$text_dec_fq')");


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
        roll_Status varchar(200) NOT NULL,
        count_usertest varchar(5000) NOT NULL)");
        echo "table setting✅</br>";
        $active_text = "✅ روشن";
        $connect->query("INSERT INTO setting (count_usertest,Bot_Status,roll_Status) VALUES ('0','$active_text','$active_text')");
    } else {
        $Check_filde = $connect->query("SHOW COLUMNS FROM setting LIKE 'Bot_Status'");
        if (mysqli_num_rows($Check_filde) != 1) {
            $connect->query("ALTER TABLE setting ADD Bot_Status VARCHAR(200)");
            echo "The Bot_Status field was added ✅";
        }
        $Check_filde = $connect->query("SHOW COLUMNS FROM setting LIKE 'roll_Status'");
        if (mysqli_num_rows($Check_filde) != 1) {
            $connect->query("ALTER TABLE setting ADD roll_Status VARCHAR(200)");
            $connect->query("UPDATE setting SET roll_Status = '✅ روشن '");
            echo "The roll_Status field was added ✅";
        }
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

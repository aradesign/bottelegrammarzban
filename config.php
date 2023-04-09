<?php
//-----------------------------database-------------------------------
$dbname = "databasename"; //  نام دیتابیس
$username = "databasename"; // نام کاربری دیتابیس
$password = 'password'; // رمز عبور دیتابیس
$connect = mysqli_connect("localhost", $username, $password, $dbname);
//-----------------------------ifno-------------------------------
$token = "TOKEN";  //  توکن ربات خود
$adminnumber ="111111";//   آیدی عددی ادمین بطور پیشفرض
//-----------------------------ifno panel-------------------------------
$url_panel = "https://site.com:8080";//آدرس پنل مرزبان
$username_panel = "admin";// نام کاربری پنل مرزبان
$password_panel ="admin"; // رمز عبور پنل مرزبان
$time = "1";// زمان پایان یوزر تست براساس ساعت
$val = "100";// حجم اکانت تست براساس مگابایت
$limit_usertest ='1';// محدودیت ساخت اکانت تست  بطور پیشفرض


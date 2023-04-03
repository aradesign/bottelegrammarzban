<?php
# id telegram @gholipour3
#اطلاعات پنل در این فایل وارد کنید
$url_panel="https://sitepanelmarzban:8080";
/* درصورتی که آدرس پنل پورت دارد پورت را وارد کنید در غیراینصورت بدون پورت آدرس پنل بزنید*/
$username_panel = "admin";#نام کاربری پنل مرزبان را وارد کنید
$password_panel = "admin"; # رمز عبور پنل مرزبان را وارد نمایید


function bot($method, $datas = [])
{
    $url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}
#-----------------------------#
function getuser($username)
{
    global $url_panel;
    $token = token_panel();
    $usernameac = $username;
    $url =  $url_panel.'/api/user/' . $usernameac;
    $header_value = 'Bearer ';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Authorization: ' . $header_value . $token
    ));

    $output = curl_exec($ch);
    curl_close($ch);
    $data_useer = json_decode($output, true);
    return $data_useer;
}
#-----------------------------#
function token_panel(){
    global $url_panel;
    global $username_panel;
    global $password_panel;
    $url_get_token = $url_panel.'/api/admin/token';
    $data_token = array(
        'username' => $username_panel,
        'password' => $password_panel
    );
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data_token),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'accept: application/json'
        )
    );
    $curl_token = curl_init($url_get_token);
    curl_setopt_array($curl_token, $options);
    $token = curl_exec($curl_token);
    curl_close($curl_token);

    $body = json_decode($token, true);
    $token = $body['access_token'];
    return $token;
}

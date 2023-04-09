<?php
include('config.php');
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
function adduser($username,$expire,$data_limit)
{
 $token = token_panel();
     global $url_panel;
    $url = $url_panel."/api/user";
    $header_value = 'Bearer ';
    $data = array(
        "proxies" => array(
            "vmess" => array(),
            "vless" => array(),
            "trojan" => array()
        ),
        "expire" => $expire,
        "data_limit" => $data_limit,
        "username" => $username
    );

    $payload = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json',
        'Authorization: ' . $header_value . $token,
        'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

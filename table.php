<?php
include('config.php');
//-----------------------------------------------------------------
try {
    $result = $connect->query("SHOW TABLES LIKE 'user'");
    $table_exists = ($result->num_rows > 0);

    if (!$table_exists) {
        $connect->query("CREATE TABLE user (
        id varchar(30) PRIMARY KEY,
        limit_usertest int(100) NOT NULL,
        Processing_value varchar(100000) NOT NULL,
        step varchar(5000) NOT NULL)");
        echo "table user✅</br>";
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
        count_usertest varchar(5000) NOT NULL)");
        echo "table setting✅</br>"
                $connect->query("INSERT INTO setting (count_usertest) VALUES ('0')");;
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

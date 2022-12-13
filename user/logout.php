<?php

$email = $_COOKIE['email'];
$userKey = $_COOKIE['userKey'];
$conn = mysqli_connect('localhost', 'root', '', 'courier_app');

if ($conn) {
    $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) != 0) {
        $user = mysqli_fetch_assoc($res);
        $sql = "UPDATE users SET userKey = '' WHERE email = '$email'";
        if (mysqli_query($conn, $sql)) {
            echo "success";
        }
    }
}
setcookie("userKey", $userKey, time() - (86400), "/"); // 86400 = 1 day
setcookie("email", $email, time() - (86400), "/"); // 86400 = 1 day
setcookie("role", $role, time() - (86400), "/"); // 86400 = 1 day
setcookie("name", $name, time() - (86400), "/"); // 86400 = 1 day

header('location: /courier_app_web/');

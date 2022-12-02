<?php
if (!empty($_POST['email']) && !empty($_POST['userKey'])) {
    $email = $_POST['email'];
    $userKey = $_POST['userKey'];
    $result = array();

    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            $user = mysqli_fetch_assoc($res);

            $result = array("status" => "success", "message" => "User Fetched Successfully", "name" => $user['name'], "email" => $user['email'], "userKey" => $user['userKey']);
        } else {
            $result = array("status" => "failed", "message" => "Unauthorized Access");
        }
    } else {
        $result = array("status" => "failed", "message" => "Database connection failed.");
    }
} else {
    $result = array("status" => "failed", "message" => "All fields are required.");
}

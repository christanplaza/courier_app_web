<?php
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = array();

    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) != 0) {
            $user = mysqli_fetch_assoc($res);

            if ($email == $user['email'] && md5($password) == $user['password']) {
                try {
                    $userKey = bin2hex(random_bytes(23));
                } catch (Exception $e) {
                    $userKey = bin2hex(uniqid($email, true));
                }

                $sql = "UPDATE users SET userKey = '$userKey' WHERE email = '$email'";
                if (mysqli_query($conn, $sql)) {
                    $result = array("status" => "success", "message" => "Login Successful", "name" => $user['name'], "email" => $user['email'], "userKey" => $userKey, "role" => $user['role']);
                } else {
                    $result = array("status" => "failed", "message" => "Login failed, try again.");
                }
            } else {
                $result = array("status" => "failed", "message" => "Incorrect email/password.");
            }
        } else {
            $result = array("status" => "failed", "message" => "Incorrect email/password.");
        }
    } else {
        $result = array("status" => "failed", "message" => "Database connection failed.");
    }
} else {
    $result = array("status" => "failed", "message" => "All fields are required.");
}

echo json_encode($result, JSON_PRETTY_PRINT);

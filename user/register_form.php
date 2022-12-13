<?php
session_start();
if (isset($_POST['submit'])) {
    if (!empty($_POST['name']) && !empty($_POST['contact_number']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
        if ($_POST['password'] === $_POST['password_confirm']) {
            $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

            $name = $_POST['name'];
            $contact_number = $_POST['contact_number'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $role = 'customer';

            if ($conn) {

                $sql = "SELECT * FROM users WHERE email = '$email'";

                $res = mysqli_query($conn, $sql);

                if (mysqli_num_rows($res) != 0) {
                    $result = array("status" => "danger", "message" => "Email already Exists");
                } else {
                    $sql = "INSERT into users (name, contact_number, role, email, password) values ('$name', '$contact_number', '$role', '$email', '$password')";

                    if (mysqli_query($conn, $sql)) {
                        $result = array("status" => "success", "message" => "Account Created");
                    } else {
                        $result = array("status" => "danger", "message" => "Registration Failed");
                    }
                }
            } else {
                $result = array("status" => "danger", "message" => "Database connection failed.");
            }
        } else {
            $result = array("status" => "danger", "message" => "Password is not the same");
        }
    } else {
        $result = array("status" => "danger", "message" => "All fields are required");
    }

    $_SESSION['msg_type'] = $result['status'];
    $_SESSION['flash_message'] = $result['message'];

    if ($result['status'] == "danger") {
        header('location: /courier_app_web/register.php');
    } else {
        header('location: /courier_app_web/login.php');
    }
}

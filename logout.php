<?php
if (!empty($_POST['email']) && !empty($_POST['userKey'])) {
    $email = $_POST['email'];
    $userKey = $_POST['userKey'];
    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) != 0) {
            $user = mysqli_fetch_assoc($res);
            $sql = "UPDATE users SET userKey = '' WHERE email = '$email'";
            if (mysqli_query($conn, $sql)) {
                echo "success";
            } else echo "Logout Failed";
        } else echo "Unauthorized Access";
    } else echo "Database connection failed";
} else echo "All fields are required";

<?php

if (!empty($_POST['email']) && !empty($_POST['userKey'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    $email = $_POST['email'];
    $userKey = $_POST['userKey'];

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            $user = mysqli_fetch_assoc($res);
            $data = [];

            $sql = "SELECT `users`.id AS userID, `users`.*, `job_orders`.* FROM job_orders INNER JOIN users ON `job_orders`.customer_id = `users`.id WHERE status = 'Pending';";

            $res = mysqli_query($conn, $sql);
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    $data[] = $row;
                }
                $result = array("status" => "success", "orders" => $data);
            } else {
                $result = array("status" => "failed", "message" => "$res");
            }
        } else {
            $result = array("status" => "failed", "message" => "Unauthorized Access");
        }
    } else {
        $result = array("status" => "failed", "message" => "Database connection failed.");
    }
} else {
    $result = array("status" => "failed", "message" => "All fields are required");
}

echo json_encode($result, JSON_PRETTY_PRINT);

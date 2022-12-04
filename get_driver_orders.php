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
            $driverID = $user['id'];

            $sql = "SELECT `users`.name, `users`.contact_number, `job_orders`.* FROM job_orders INNER JOIN users ON `job_orders`.customer_id = `users`.id WHERE (courier_id = '$driverID') AND status = 'Ongoing'";

            $job_order_res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($job_order_res) != 0) {
                $order = mysqli_fetch_assoc($job_order_res);
                $result = array("status" => "success", "order" => $order);
            } else {
                $result = array("status" => "failed", "message" => "Something went wrong.");
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


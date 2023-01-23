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
            $customer_id = $user['id'];
            $data = [];

            $sql = "SELECT * FROM users WHERE role = 'driver'";

            $res = mysqli_query($conn, $sql);
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    $driverId = $row['id'];
                    $sql = "SELECT * FROM job_orders WHERE (courier_id = '$driverId') AND (status = 'Ongoing' OR status = 'In Transit')";

                    $job_order_res = mysqli_query($conn, $sql);
                    if (!$job_order_res || mysqli_num_rows($job_order_res) == 0) {
                        $data[] = $row;
                    }
                }
                $result = array("status" => "success", "drivers" => $data);
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

<?php
date_default_timezone_set('Asia/Singapore');
if (!empty($_POST['email']) && !empty($_POST['userKey']) && !empty($_POST['orderID']) && !empty($_POST['status'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    $email = $_POST['email'];
    $userKey = $_POST['userKey'];
    $orderID = $_POST['orderID'];
    $status = $_POST['status'];
    $today = date('Y-m-d H:i');

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            $sql = "INSERT INTO job_order_status (job_order_id, status, status_message, datetime) VALUES ('$orderID', 'In Transit', '$status', '$today');";

            if (mysqli_query($conn, $sql)) {
                $result = array("status" => "success", "message" => "Status Update Sent");
            } else {
                $result = array("status" => "failed", "message" => "Something went wrong");
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

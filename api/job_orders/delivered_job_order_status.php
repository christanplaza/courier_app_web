<?php
date_default_timezone_set('Asia/Singapore');
if (!empty($_POST['email']) && !empty($_POST['userKey']) && !empty($_POST['orderID'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'courier_app');

    $email = $_POST['email'];
    $userKey = $_POST['userKey'];
    $orderID = $_POST['orderID'];
    $today = date('Y-m-d H:i');

    if ($conn) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND userKey = '$userKey'";

        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) != 0) {
            $sql = "INSERT INTO `job_order_status` (`job_order_id`, `status`, `status_message`, `datetime`) VALUES ('$orderID', 'Delivered', 'Products Delivered Successfully', '$today');";

            if (mysqli_query($conn, $sql)) {
                $sql = "UPDATE job_orders SET status = 'Delivered', datetime_arrived = '$today' WHERE id = '$orderID'";

                if (mysqli_query($conn, $sql)) {
                    $result = array("status" => "success", "message" => "Job Order Delivered");
                } else {
                    $result = array("status" => "failed", "message" => "Something went wrong");
                }
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

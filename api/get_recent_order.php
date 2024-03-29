<?php
if (!empty($_POST['email']) && !empty($_POST['userKey'])) {
    date_default_timezone_set('Asia/Singapore');
    $today = date('Y-m-d');
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

            $sql = "SELECT * FROM job_orders WHERE customer_id = '$customer_id' AND status = 'Delivered' AND date_placed <= '$today' LIMIT 1";

            $res = mysqli_query($conn, $sql);
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    $data[] = $row;
                }
                $result = array("status" => "success", "orders" => $data);
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
